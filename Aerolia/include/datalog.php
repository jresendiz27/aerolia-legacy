<?php

    class DataLog {


        public static function request_history($aero_id, $order_id, $wrapper) {

            switch ($order_id) {
                case 1:
                    $order = "fecha_historial DESC";
                    break;
                case 2:
                    $order = "fecha_historial ASC";
                    break;
                case 3:
                    $order = "id_evento ASC, fecha_historial DESC";
                    break;
                case 4:
                    $order = "id_evento ASC, fecha_historial ASC";
                    break;
                default:
                    $order = "fecha_historial DESC";
            }

            $result = $wrapper->simple_query(Array("m_historial", "c_evento"), "id_aero = ".$aero_id, $order);

            $history = array();

            foreach ($result as $info) {

                $period = date("Y-m", strtotime($info["fecha_historial"]));

                $history[$period][] = $info;

            }

            switch ($order_id) {
                case 1:
                case 3:
                    krsort($history);
                    break;
                case 2:
                case 4:
                    ksort($history);
                    break;
                default:
                    krsort($history);
            }

            return $history;

        }


        public static function request_recent_data($id, $wrapper) {

            $data_types = $wrapper->simple_query("c_tipodato");

            foreach ($data_types as $type) {
                $last_data = $wrapper->simple_query(
                    Array("m_dato", "c_tipodato"),
                    "id_aero = ".$id." AND id_tipodato = ".$type["id_tipodato"],
                    "fec_dato DESC",
                    1
                );
                $result[] = Array(
                    "date" => $last_data[0]["fec_dato"],
                    "type" => $last_data[0]["id_tipodato"],
                    "desc" => $last_data[0]["desc_tipodato"],
                    "unit" => $last_data[0]["unidad_tipodato"],
                    "value" => $last_data[0]["val_dato"]
                );
            }

            return $result;

        }


        public static function request_daily_data($id, $date, $wrapper) {

            $data_types = $wrapper->simple_query("c_tipodato");

            $data = $wrapper->simple_query(
                "m_dato",
                "id_aero = ".$id." AND fec_dato BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59'",
                null,
                1
            );

            if (count($data) == 0) {
                return null;
            }

            $result = Array();

            foreach ($data_types as $type) {

                $dataset = Array();
                $mean = 0;
                $hmean = 0;
                $median = 0;
                $q1 = 0;
                $q3 = 0;
                $variance = 0;

                $data = $wrapper->simple_query(
                    Array("m_dato", "c_tipodato"),
                    "id_aero = ".$id." AND id_tipodato = ".$type["id_tipodato"]
                    ." AND fec_dato BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59'",
                    "fec_dato ASC"
                );

                $max = $data[0]["val_dato"];
                $min = $data[0]["val_dato"];

                foreach ($data as $databit) {

                    $mean += $databit["val_dato"];
                    if ($hmean !== "Err") {
                        if ($databit["val_dato"] == 0) {
                            $hmean = "Err";
                        } else {
                            $hmean = $hmean + (1 / $databit["val_dato"]);
                        }
                    }

                    if ($databit["val_dato"] > $max) {
                        $max = $databit["val_dato"];
                    }
                    if ($databit["val_dato"] < $min) {
                        $min = $databit["val_dato"];
                    }

                    $dataset["time"][] = strtotime($databit["fec_dato"]);
                    $dataset["value"][] = (float)$databit["val_dato"];
                }

                $mean /= count($dataset["value"]);
                if (($hmean !== "Err") && ($hmean != 0)) {
                    $hmean = count($dataset["value"]) / $hmean;
                } else {
                    $hmean = "Err";
                }
                if ((count($dataset["value"]) % 2) == 0) {
                    $median =
                        ($dataset["value"][(count($dataset) / 2) - 1]
                        + $dataset["value"][(count($dataset) / 2)])
                        / 2;
                } else {
                    $median = $dataset["value"][(count($dataset) - 1) / 2];
                }
                $q1 = $dataset["value"][(int)((count($dataset) - 1) / 4)];
                $q3 = $dataset["value"][(int)(((count($dataset) - 1) * 3) / 4)];

                foreach ($data as $databit) {
                    $diff = (float)($databit["val_dato"]) - $mean;
                    $variance = pow($diff, 2);
                }
                $variance /= count($dataset["value"]);

                $result[$data[0]["id_tipodato"]] = Array(
                    "type" => $data[0]["id_tipodato"],
                    "desc" => $data[0]["desc_tipodato"],
                    "unit" => $data[0]["unidad_tipodato"],
                    "dataset" => $dataset,
                    "mean" => $mean,
                    "hmean" => $hmean,
                    "median" => $median,
                    "max" => $max,
                    "min" => $min,
                    "q1" => $q1,
                    "q3" => $q3,
                    "qrange" => ($q3 - $q1),
                    "variance" => $variance,
                    "sdeviation" => pow($variance, 0.5)
                );

            }

            return $result;

        }


        public static function request_weekly_data($id, $start_date, $wrapper) {

            $data_types = $wrapper->simple_query("c_tipodato");
            $end_date = date("Y-m-d", strtotime($start_date) + (7 * 24 * 60 * 60));

            $data = $wrapper->simple_query(
                "m_dato",
                "id_aero = ".$id." AND fec_dato BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 00:00:00'",
                null,
                1
            );

            if (count($data) == 0) {
                return null;
            }

            $result = Array();

            foreach ($data_types as $type) {

                $dataset = Array();
                $mean = 0;
                $hmean = 0;
                $median = 0;
                $q1 = 0;
                $q3 = 0;
                $variance = 0;

                $data = $wrapper->simple_query(
                    Array("m_dato", "c_tipodato"),
                    "id_aero = ".$id." AND id_tipodato = ".$type["id_tipodato"]
                    ." AND fec_dato BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 00:00:00'",
                    "fec_dato ASC"
                );

                $max = $data[0]["val_dato"];
                $min = $data[0]["val_dato"];

                foreach ($data as $databit) {

                    $mean += $databit["val_dato"];
                    if ($hmean !== "Err") {
                        if ($databit["val_dato"] == 0) {
                            $hmean = "Err";
                        } else {
                            $hmean = $hmean + (1 / $databit["val_dato"]);
                        }
                    }

                    if ($databit["val_dato"] > $max) {
                        $max = $databit["val_dato"];
                    }
                    if ($databit["val_dato"] < $min) {
                        $min = $databit["val_dato"];
                    }

                    $dataset["time"][] = strtotime($databit["fec_dato"]);
                    $dataset["value"][] = (float)$databit["val_dato"];
                }

                $mean /= count($dataset["value"]);
                if (($hmean !== "Err") && ($hmean != 0)) {
                    $hmean = count($dataset["value"]) / $hmean;
                } else {
                    $hmean = "Err";
                }
                if ((count($dataset["value"]) % 2) == 0) {
                    $median =
                        ($dataset["value"][(count($dataset) / 2) - 1]
                        + $dataset["value"][(count($dataset) / 2)])
                        / 2;
                } else {
                    $median = $dataset["value"][(count($dataset) - 1) / 2];
                }
                $q1 = $dataset["value"][(int)((count($dataset) - 1) / 4)];
                $q3 = $dataset["value"][(int)(((count($dataset) - 1) * 3) / 4)];

                foreach ($data as $databit) {
                    $diff = (float)($databit["val_dato"]) - $mean;
                    $variance = pow($diff, 2);
                }
                $variance /= count($dataset["value"]);

                $result[$data[0]["id_tipodato"]] = Array(
                    "type" => $data[0]["id_tipodato"],
                    "desc" => $data[0]["desc_tipodato"],
                    "unit" => $data[0]["unidad_tipodato"],
                    "dataset" => $dataset,
                    "mean" => $mean,
                    "hmean" => $hmean,
                    "median" => $median,
                    "max" => $max,
                    "min" => $min,
                    "q1" => $q1,
                    "q3" => $q3,
                    "qrange" => ($q3 - $q1),
                    "variance" => $variance,
                    "sdeviation" => pow($variance, 0.5)
                );

            }

            return $result;

        }


        public static function generate_graphic($id, $dataset, $graph_list, $size = 1, $show_date = false) {

            $imgdir = Array();

            foreach ($graph_list as $graph_id) {

                $graphData = new pData();

                $graphData->addPoints($dataset[$graph_id]["dataset"]["value"], "Value");
                $graphData->setAxisName(0, $dataset[$graph_id]["desc"]);
                $graphData->setAxisUnit(0, $dataset[$graph_id]["unit"]);
                $graphData->setPalette("Value", Array("R"=>40, "G"=>100, "B"=>0));

                $graphData->addPoints($dataset[$graph_id]["dataset"]["time"], "Timestamp");
                $graphData->setSerieDescription("Timestamp", "Hora");
                $graphData->setAbscissa("Timestamp");
                if ($show_date) {
                    $graphData->setXAxisDisplay(AXIS_FORMAT_DATE, "Y-m-d H:i:s");
                } else {
                    $graphData->setXAxisDisplay(AXIS_FORMAT_DATE, "H:i:s");
                }

                $canvas = new pImage(600 * $size, 200 * $size, $graphData);
                $canvas->Antialias = FALSE;

                $canvas->setFontProperties(Array("FontName"=>"./include/pchart/fonts/calibri.ttf", "FontSize"=>(8 * $size)));
                $canvas->setGraphArea(70 * $size, 20 * $size, 580 * $size, 180 * $size);
                $canvas->drawScale(Array("DrawSubTicks"=>TRUE, "DrawArrows"=>TRUE, "ArrowSize"=>(6 * $size)));
                $canvas->drawLineChart(Array("DisplayValues"=>FALSE, "DisplayColor"=>DISPLAY_AUTO));

                $imgdir[$graph_id] = "./rcache/".$id."_".$graph_id.".png";

                $canvas->Render($imgdir[$graph_id]);

            }

            return $imgdir;

        }


        public static function generate_daily_report($id, $date, $dataset, $graph_list) {

            $imgset = DataLog::generate_graphic($id, $dataset, $graph_list, 2);

            $pdf = new DaliyReportPDF();
            $pdf->date = $date;
            $pdf->AliasNbPages();

            foreach ($graph_list as $graph_id) {

                $pdf->AddPage();

                $pdf->SetFont("Arial", "B", 16);
                $pdf->Cell(0, 10, utf8_decode($dataset[$graph_id]["desc"]), 0, 1);

                $pdf->Image($imgset[$graph_id], 10, 50, 170);
                $pdf->Ln(80);

                $pdf->SetFont("Arial", "B", 12);
                $pdf->Cell(50, 10, utf8_decode("Estadísticas: "), 0, 1);

                $pdf->SetFont("Arial", "B", 10);
                $pdf->Cell(50, 10, utf8_decode("Media aritmética: "), 0);
                $pdf->SetFont("Arial", "", 10);
                $pdf->Cell(0, 10, $dataset[$graph_id]["mean"]." ".$dataset[$graph_id]["unit"], 0, 1);

                $pdf->SetFont("Arial", "B", 10);
                $pdf->Cell(50, 10, utf8_decode("Media armónica: "), 0);
                $pdf->SetFont("Arial", "", 10);
                $pdf->Cell(0, 10, $dataset[$graph_id]["hmean"]." ".$dataset[$graph_id]["unit"], 0, 1);

                $pdf->SetFont("Arial", "B", 10);
                $pdf->Cell(50, 10, utf8_decode("Mediana: "), 0);
                $pdf->SetFont("Arial", "", 10);
                $pdf->Cell(0, 10, $dataset[$graph_id]["median"]." ".$dataset[$graph_id]["unit"], 0, 1);

                $pdf->SetFont("Arial", "B", 10);
                $pdf->Cell(50, 10, utf8_decode("Cuartil 1 - Cuartil 3: "), 0);
                $pdf->SetFont("Arial", "", 10);
                $pdf->Cell(0, 10, $dataset[$graph_id]["q1"]." - ".$dataset[$graph_id]["q3"]." ".$dataset[$graph_id]["unit"], 0, 1);

                $pdf->SetFont("Arial", "B", 10);
                $pdf->Cell(50, 10, utf8_decode("Rango intercuartílico: "), 0);
                $pdf->SetFont("Arial", "", 10);
                $pdf->Cell(0, 10, $dataset[$graph_id]["qrange"]." ".$dataset[$graph_id]["unit"], 0, 1);

                $pdf->SetFont("Arial", "B", 10);
                $pdf->Cell(50, 10, utf8_decode("Varianza: "), 0);
                $pdf->SetFont("Arial", "", 10);
                $pdf->Cell(0, 10, $dataset[$graph_id]["variance"], 0, 1);

                $pdf->SetFont("Arial", "B", 10);
                $pdf->Cell(50, 10, utf8_decode("Desviación estándar: "), 0);
                $pdf->SetFont("Arial", "", 10);
                $pdf->Cell(0, 10, $dataset[$graph_id]["sdeviation"], 0, 1);

            }

            $pdf->Output();

        }


    }

?>