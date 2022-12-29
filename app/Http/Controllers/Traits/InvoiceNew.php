<?php

namespace App\Http\Controllers\Traits;

trait InvoiceNew {
    
    function button_list($data, $access) {
        $invoice_detail = "javascript:ajaxLoad('".route('local.inv.detail.new.index', $data->id)."')";
        $action = "";
        $title = "'".$data->inv_no."'";

        if($access->can('invoice.view') && $data->inv_status == 1 ){
            $action .= '<a href="'.$invoice_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
        }

        if($access->can('invoice.update') && $data->inv_status == 1 ){
            $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
        }

        if($access->can('invoice.delete') && $data->inv_status == 1 ){
            $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
        }

        if($access->can('invoice.view') && $data->inv_status !== 1){
            $action .= '<a href="'.$invoice_detail.'" class="btn btn-success btn-xs"> Open</a> ';
        }
        if($access->can('invoice.verify1') && $data->inv_status == 2){
            $action .= '<button id="'. $data->id .'" onclick="verify1('. $data->id .')" class="btn btn-info btn-xs"> Verify 1</button> ';
        }
        if($access->can('invoice.verify2') && $data->inv_status == 3){
            $action .= '<button id="'. $data->id .'" onclick="verify2('. $data->id .')" class="btn btn-info btn-xs"> Verify 2</button> ';
        }
        if($access->can('invoice.approve') && $data->inv_status == 4){
            $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
        }
        if($access->can('invoice.print') && ($data->inv_status == 5 || $data->inv_status == 6 || $data->inv_status == 7 || $data->inv_status == 8)){
            $action .= '<button id="'. $data->id .'" onclick="print_inv('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
        }
        return $action;
    }

    function button_sppb_list_add ($data, $access){
        $action = "";
        if($data->invoice_id == 0){
            $action .= '<button type="button" id="'. $data->id .'" onclick="addItem('. $data->id .')" class="btn btn-info btn-xs"> Add Item</button> ';
        }
        if($data->invoice_id != 0 && ($data->invoice_status == 1 || $data->invoice_status == 2 )){
            $title = "'".$data->sppb_no."'";
            $action .= '<button type="button" id="delete_'. $data->id .'" onclick="deleteItem('. $data->id .', '.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
        }
        return $action;
    }

    function button_edit_invoice_detail($data, $inv_stat, $access){
        $action = "";
        $title = "'".$data->stock_master->name."'";
        if($data->invoice->inv_status == 1){
            if($access->can('invoice.update')){
                $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
            }
        }
        if($data->invoice->inv_status == 2){
            if($access->can('invoice.update')){
                $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
            }
        }
        if($inv_stat == 1){
            $action .= '<button id="'. $data->id .'" onclick="addItem('. $data->id .')" class="btn btn-info btn-xs"> Add Item</button> ';
        }
        return $action;
    }
}