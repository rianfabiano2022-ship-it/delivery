<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once "../../../funcoes/Conexao.php";
require_once "../../../funcoes/Key.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// ---------- Função para aplicar zebra (linhas alternadas) ----------
function applyZebraStyle($sheet, $startRow, $endRow, $startCol, $endCol, $color = 'F2F2F2') {
    for ($r = $startRow; $r <= $endRow; $r++) {
        if (($r - $startRow) % 2 == 1) {
            $sheet->getStyle("{$startCol}{$r}:{$endCol}{$r}")
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
        }
    }
}

if (isset($_POST["data_i"])) {
    $user_o = $_POST["idusr"];
    $data_i = date('Y-m-d', strtotime($_POST['data_i']));
    $data_f = date('Y-m-d', strtotime($_POST['data_f']));

    // Saldo inicial do caixa (aceita formato brasileiro)
    if (isset($_POST['saldo_inicial']) && $_POST['saldo_inicial'] !== '') {
        $strSaldo = str_replace('.', '', $_POST['saldo_inicial']);
        $strSaldo = str_replace(',', '.', $strSaldo);
        $saldo_inicial = floatval($strSaldo);
    } else {
        $saldo_inicial = 200.00;
    }

    // Buscar pedidos
    $stmt = $connect->prepare("
        SELECT id, vtotal, status, entrada, fpagamento, troco
        FROM pedidos
        WHERE DATE(entrada) BETWEEN :data_i AND :data_f
          AND idu = :idu
        ORDER BY entrada ASC
    ");
    $stmt->execute([':data_i'=>$data_i, ':data_f'=>$data_f, ':idu'=>$user_o]);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcular Troco e Caixa Recebido Líquido
    $trocoDadoTotal = 0.0;
    $caixaRecebidoLiquido = 0.0;
    foreach ($pedidos as &$p) {
        $pTroco = isset($p['troco']) ? floatval($p['troco']) : 0.0;
        $pVtotal = isset($p['vtotal']) ? floatval($p['vtotal']) : 0.0;

        $p['troco_dado'] = 0.0;

        if (strtoupper($p['fpagamento']) === 'DINHEIRO' && strval($p['status']) === '5') {
            $trocoDado = $pTroco - $pVtotal;
            $p['troco_dado'] = $trocoDado > 0 ? $trocoDado : 0.0;
            $caixaRecebidoLiquido += $pVtotal;
            $trocoDadoTotal += $p['troco_dado'];
        }
    }
    unset($p);

    // Saldo final esperado não subtrai o troco dado
    $saldo_final_esperado = $saldo_inicial + $caixaRecebidoLiquido;

    // Resumos gerais
    $stmt = $connect->prepare("
        SELECT SUM(vtotal) AS total, COUNT(*) AS qtd
        FROM pedidos
        WHERE DATE(entrada) BETWEEN :data_i AND :data_f AND idu = :idu
    ");
    $stmt->execute([':data_i'=>$data_i, ':data_f'=>$data_f, ':idu'=>$user_o]);
    $totalGeral = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $connect->prepare("
        SELECT SUM(vtotal) AS total, COUNT(*) AS qtd
        FROM pedidos
        WHERE DATE(entrada) BETWEEN :data_i AND :data_f AND idu = :idu AND status='5'
    ");
    $stmt->execute([':data_i'=>$data_i, ':data_f'=>$data_f, ':idu'=>$user_o]);
    $finalizados = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $connect->prepare("
        SELECT SUM(vtotal) AS total, COUNT(*) AS qtd
        FROM pedidos
        WHERE DATE(entrada) BETWEEN :data_i AND :data_f AND idu = :idu AND status='6'
    ");
    $stmt->execute([':data_i'=>$data_i, ':data_f'=>$data_f, ':idu'=>$user_o]);
    $cancelados = $stmt->fetch(PDO::FETCH_ASSOC);

    // Totais diários (total geral por dia)
    $stmt = $connect->prepare("
        SELECT DATE(entrada) AS dia, SUM(vtotal) AS total, COUNT(*) AS qtd
        FROM pedidos
        WHERE DATE(entrada) BETWEEN :data_i AND :data_f AND idu = :idu
        GROUP BY DATE(entrada) ORDER BY DATE(entrada)
    ");
    $stmt->execute([':data_i'=>$data_i, ':data_f'=>$data_f, ':idu'=>$user_o]);
    $totaisDiarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Totais diários por forma de pagamento
    $stmt = $connect->prepare("
        SELECT DATE(entrada) AS dia, fpagamento, SUM(vtotal) AS total, COUNT(*) AS qtd
        FROM pedidos
        WHERE DATE(entrada) BETWEEN :data_i AND :data_f AND idu = :idu
        GROUP BY DATE(entrada), fpagamento
        ORDER BY DATE(entrada), fpagamento
    ");
    $stmt->execute([':data_i'=>$data_i, ':data_f'=>$data_f, ':idu'=>$user_o]);
    $totaisPorPagamento = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Organiza por data e forma de pagamento
    $diariosPagamento = [];
    foreach ($totaisPorPagamento as $linha) {
        $dia = $linha['dia'];
        $fpag = strtoupper(trim($linha['fpagamento']));
        if ($fpag === 'CARTÃO') $fpag = 'CARTAO';
        if (!isset($diariosPagamento[$dia])) {
            $diariosPagamento[$dia] = [
                'CARTAO' => ['total' => 0, 'qtd' => 0],
                'PIX' => ['total' => 0, 'qtd' => 0],
                'DINHEIRO' => ['total' => 0, 'qtd' => 0],
            ];
        }
        if (isset($diariosPagamento[$dia][$fpag])) {
            $diariosPagamento[$dia][$fpag]['total'] = floatval($linha['total']);
            $diariosPagamento[$dia][$fpag]['qtd'] = intval($linha['qtd']);
        }
    }

    // ---------------------------
    // Criar planilha
    // ---------------------------
    $spreadsheet = new Spreadsheet();

    // ---------- Aba 1: Caixa Diário ----------
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Caixa Diário');

    $sheet->mergeCells('A1:D1');
    $sheet->setCellValue('A1', "Caixa Diário ({$_POST['data_i']} até {$_POST['data_f']})");
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18)->getColor()->setRGB('FFFFFF');
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A1')->getFill()
        ->setFillType(Fill::FILL_GRADIENT_LINEAR)
        ->setRotation(90)
        ->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('4F81BD'))
        ->setEndColor(new \PhpOffice\PhpSpreadsheet\Style\Color('1D3557'));

    $linha = 3;
    $sheet->setCellValue("A{$linha}", "Saldo Inicial (R$)");
    $sheet->setCellValue("B{$linha}", "Total Recebido Líquido (R$)");
    $sheet->setCellValue("C{$linha}", "Troco Dado (R$)");
    $sheet->setCellValue("D{$linha}", "Saldo Final Esperado (R$)");

    $sheet->getStyle("A{$linha}:D{$linha}")->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
    $sheet->getStyle("A{$linha}:D{$linha}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('457B9D');
    $sheet->getStyle("A{$linha}:D{$linha}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle("A{$linha}:D{$linha}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);

    $linha++;
    $sheet->setCellValue("A{$linha}", "R$ " . number_format($saldo_inicial, 2, ',', '.'));
    $sheet->setCellValue("B{$linha}", "R$ " . number_format($caixaRecebidoLiquido, 2, ',', '.'));
    $sheet->setCellValue("C{$linha}", "R$ " . number_format($trocoDadoTotal, 2, ',', '.'));
    $sheet->setCellValue("D{$linha}", "R$ " . number_format($saldo_final_esperado, 2, ',', '.'));

    $sheet->getStyle("A{$linha}:D{$linha}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $sheet->getStyle("A{$linha}:D{$linha}")->getFont()->setSize(12);
    $sheet->getStyle("A{$linha}:D{$linha}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    foreach (range('A', 'D') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // ---------- Aba 2: Pedidos Detalhados ----------
    $sheet2 = $spreadsheet->createSheet();
    $sheet2->setTitle('Pedidos Detalhados');
    $sheet2->mergeCells('A1:F1');
    $sheet2->setCellValue('A1', "Pedidos ({$_POST['data_i']} até {$_POST['data_f']})");
    $sheet2->getStyle('A1')->getFont()->setBold(true)->setSize(18)->getColor()->setRGB('FFFFFF');
    $sheet2->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet2->getStyle('A1')->getFill()
        ->setFillType(Fill::FILL_GRADIENT_LINEAR)
        ->setRotation(90)
        ->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('4BACC6'))
        ->setEndColor(new \PhpOffice\PhpSpreadsheet\Style\Color('2A9D8F'));

    $linha = 3;
    $sheet2->setCellValue("A{$linha}", "ID Pedido");
    $sheet2->setCellValue("B{$linha}", "Valor (R$)");
    $sheet2->setCellValue("C{$linha}", "Status");
    $sheet2->setCellValue("D{$linha}", "Data Entrada");
    $sheet2->setCellValue("E{$linha}", "Pagamento");
    $sheet2->setCellValue("F{$linha}", "Troco Dado (R$)");

    $sheet2->getStyle("A{$linha}:F{$linha}")->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
    $sheet2->getStyle("A{$linha}:F{$linha}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('008080');
    $sheet2->getStyle("A{$linha}:F{$linha}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet2->getStyle("A{$linha}:F{$linha}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);

    $linha++;
    $rowStart = $linha;
    foreach ($pedidos as $p) {
        switch (strval($p['status'])) {
            case '1': $statusTxt = 'Pedido Feito'; $cor = 'FFD600'; break;
            case '2': $statusTxt = 'Pedido Aceito'; $cor = 'FFD600'; break;
            case '3': $statusTxt = 'Saiu para entrega'; $cor = 'FFD600'; break;
            case '4': $statusTxt = 'Disponível para retirada'; $cor = 'FFD600'; break;
            case '5': $statusTxt = 'Finalizado'; $cor = '43AA8B'; break;
            case '6': $statusTxt = 'Cancelado'; $cor = 'FF2525'; break;
            default:  $statusTxt = 'Outro'; $cor = 'D9D9D9'; break;
        }
        $trocoDadoLinha = isset($p['troco_dado']) ? floatval($p['troco_dado']) : 0.0;
        $sheet2->setCellValue("A{$linha}", $p['id']);
        $sheet2->setCellValue("B{$linha}", "R$ " . number_format(floatval($p['vtotal']), 2, ',', '.'));
        $sheet2->setCellValue("C{$linha}", $statusTxt);
        $sheet2->setCellValue("D{$linha}", date('d/m/Y H:i', strtotime($p['entrada'])));
        $sheet2->setCellValue("E{$linha}", $p['fpagamento']);
        $sheet2->setCellValue("F{$linha}", "R$ " . number_format($trocoDadoLinha, 2, ',', '.'));

        $sheet2->getStyle("C{$linha}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($cor);
        $sheet2->getStyle("A{$linha}:F{$linha}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $linha++;
    }
    $rowEnd = $linha - 1;
    applyZebraStyle($sheet2, $rowStart, $rowEnd, 'A', 'F', 'F6F8FA');

    foreach (range('A', 'F') as $col) {
        $sheet2->getColumnDimension($col)->setAutoSize(true);
    }

    // ---------- Aba 3: Totais Diários ----------
    $sheet3 = $spreadsheet->createSheet();
    $sheet3->setTitle('Totais Diários');
    $sheet3->mergeCells('A1:F1');
    $sheet3->setCellValue('A1', "Totais Diários ({$_POST['data_i']} até {$_POST['data_f']})");
    $sheet3->getStyle('A1')->getFont()->setBold(true)->setSize(18)->getColor()->setRGB('FFFFFF');
    $sheet3->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet3->getStyle('A1')->getFill()
        ->setFillType(Fill::FILL_GRADIENT_LINEAR)
        ->setRotation(90)
        ->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('9BBB59'))
        ->setEndColor(new \PhpOffice\PhpSpreadsheet\Style\Color('70AD47'));

    $linha = 3;
    $sheet3->setCellValue("A{$linha}", "Data");
    $sheet3->setCellValue("B{$linha}", "Qtd Pedidos");
    $sheet3->setCellValue("C{$linha}", "Total (R$)");
    $sheet3->setCellValue("D{$linha}", "Cartão (R$)");
    $sheet3->setCellValue("E{$linha}", "Pix (R$)");
    $sheet3->setCellValue("F{$linha}", "Dinheiro (R$)");
    $sheet3->getStyle("A{$linha}:F{$linha}")->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
    $sheet3->getStyle("A{$linha}:F{$linha}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('70AD47');
    $sheet3->getStyle("A{$linha}:F{$linha}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet3->getStyle("A{$linha}:F{$linha}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);

    $linha++;
    $rowStart = $linha;
    foreach ($totaisDiarios as $d) {
        $dia = $d['dia'];
        $qtd = intval($d['qtd']);
        $total = floatval($d['total']);

        // Busca os totais por forma de pagamento
        $cartao = isset($diariosPagamento[$dia]['CARTAO']['total']) ? $diariosPagamento[$dia]['CARTAO']['total'] : 0;
        $pix = isset($diariosPagamento[$dia]['PIX']['total']) ? $diariosPagamento[$dia]['PIX']['total'] : 0;
        $dinheiro = isset($diariosPagamento[$dia]['DINHEIRO']['total']) ? $diariosPagamento[$dia]['DINHEIRO']['total'] : 0;

        $sheet3->setCellValue("A{$linha}", date('d/m/Y', strtotime($dia)));
        $sheet3->setCellValue("B{$linha}", $qtd);
        $sheet3->setCellValue("C{$linha}", "R$ " . number_format($total, 2, ',', '.'));
        $sheet3->setCellValue("D{$linha}", "R$ " . number_format($cartao, 2, ',', '.'));
        $sheet3->setCellValue("E{$linha}", "R$ " . number_format($pix, 2, ',', '.'));
        $sheet3->setCellValue("F{$linha}", "R$ " . number_format($dinheiro, 2, ',', '.'));
        $sheet3->getStyle("A{$linha}:F{$linha}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $linha++;
    }
    $rowEnd = $linha - 1;
    applyZebraStyle($sheet3, $rowStart, $rowEnd, 'A', 'F', 'F6F8FA');

    foreach (range('A', 'F') as $col) {
        $sheet3->getColumnDimension($col)->setAutoSize(true);
    }

    // ---------------------------
    // Download
    // ---------------------------
    $filename = "Relatorios_".date('Ymd_His').".xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}