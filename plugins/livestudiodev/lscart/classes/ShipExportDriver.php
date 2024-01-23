<?php namespace LivestudioDev\Lscart\Classes;

use LivestudioDev\Lscart\Models\Order;
use LivestudioDev\Lscart\Models\OrderItem;
use LivestudioDev\Lscart\Models\Settings;
use \Maatwebsite\Excel\Facades\Excel;

class ShipExportDriver {
    public function downloadOrderExport($scheme,$ids)
    {
        $contents = [];
        $csvString = "";
        if($scheme == "gls"){
            foreach ($ids as $orderid) {
                $order = Order::find($orderid);
                $line = [
                    $order->getAbsolutePrice(),
                    $order->name,
                    "HU",
                    $order->address["postcode"],
                    $order->address["city"],
                    trim($order->address["address_name"]." ".$order->address["address_type"]." ".$order->address["flat_number"]." ".$order->address["floor"]." ".$order->address["door_num"]),
                    $order->infos["note"],
                    $order->address["phone"],
                    $order->email,
                    $order->order_number,
                    "",
                    ""
                ];
                array_push($contents,$line);
            }
            $csvString = 'Összeg;Név;Ország;Irsz;Város;Utca/Hsz;Megjegyzés;Telefon;Email;Rendelésazonosító;Szolgaltatasok;Utánvét'."\n";
            foreach ($contents as $line) {
                foreach ($line as $key => $field) {
                    if($key + 1 != count($line)){
                        $csvString .= $field.";";
                    }else {
                        $csvString .= $field."\n";
                    }
                }
            }
        }else if ($scheme == "dpd") {
            foreach ($ids as $orderid) {
                $order = Order::find($orderid);
                $line = [
                    'D-B2C-COD',
                    0,
                    $order->getAbsolutePrice(),
                    "",
                    "",
                    "",
                    $order->name,
                    "",
                    $order->address["address_name"]." ".$order->address["address_type"], // Utca 1
                    "",
                    "H",
                    $order->address["postcode"],
                    $order->address["city"],
                    $order->address["phone"],
                    "",                    
                    $order->email,
                    $order->order_number,
                    $order->address["phone"]
                ];
                array_push($contents,$line);
            }
            $csvString = 'Szolgáltatás típus;Súly;COD összeg;COD referencia;Referencia;Cím referencia;Címzett neve;Kontakt;Utca1;Utca2;Ország;Irányítószám;Város;Telefonszám;Fax;E-mail;Megjegyzés;Telefonszám'."\n";
            foreach ($contents as $line) {
                foreach ($line as $key => $field) {
                    if($key + 1 != count($line)){
                        $csvString .= $field.";";
                    }else {
                        $csvString .= $field."\n";
                    }
                }
            }
        }else if ($scheme == "mpl") {
            foreach ($ids as $key => $orderid) {
                $order = Order::find($orderid);
                $line = [
                    $key,
                    $order->name,
                    $order->address["postcode"],
                    $order->address["city"],
                    1,
                    "",
                    $order->getAbsolutePrice(),
                    $order->getAbsolutePrice(),
                    "KH_HA",
                    "IDO",
                    "EFC_T",
                    "UVT",
                    "",
                    $order->email,
                    $order->address["phone"],
                    $order->order_number,
                    "", // JEGYZEKNEV
                    trim($order->address["address_name"]." ".$order->address["address_type"]." ".$order->address["flat_number"]." ".$order->address["floor"]." ".$order->address["door_num"]),
                    $order->address["address_name"],
                    $order->address["address_type"],
                    $order->address["flat_number"],
                    $order->comment,
                    "",
                    "",
                    "",
                    ""
                ];
                array_push($contents,$line);
            }
            $csvString = 'sorszam;nev;iranyitoszam;telepules;tomeg;alapdij;erteknyilvanitas;arufizetes;szolgaltatasok;dij;ragszam;ugyfeladat1;ugyfeladat2;email;telefon;partnerkod;jegyzeknev;cim;cimzett_kozterulet_nev;cimzett_kozterulet_jelleg;cimzett_kozterulet_hsz;megjegyzes;kezbesito_hely;meretX;meretY;meretZ'."\n";
            foreach ($contents as $line) {
                foreach ($line as $key => $field) {
                    if($key + 1 != count($line)){
                        $csvString .= $field.";";
                    }else {
                        $csvString .= $field."\n";
                    }
                }
            }
        }


        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="export_'.$scheme.'.csv"'
        );
        
        
        return \Response::make($csvString, '200', $headers);
    }
}