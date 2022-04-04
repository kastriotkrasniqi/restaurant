<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('order.index', compact('categories'));
    }


    public function getProductsById($id)
    {
        $products = Product::where('category_id', $id)->get();
        $html = '';
        foreach ($products as $product) {
            $html .= '<a class=" btn col-2 bg-success rounded-3 text-white text-center  pt-2  produkti"  data-id="' . $product->id . '" data-name="' . $product->name . '">';
            $html .= '<p class="fs-6 fw-bold text-decoration-none text-white">' . $product->name . '</p>';
            $html .= '<p class="fw-bold">$ ' . $product->price . ' </p>';
            $html .= '</a>';
        }

        return $html;
    }


    public function getTableId($table_id)
    {
        $categories = Category::all();

        return view('order.index', compact('table_id', 'categories'));
    }

    public function getSaleDetailsByTable($table_id)
    {
        $sale = Sale::where('table_id', $table_id)->where('sale_status', 'unpaid')->first();
        $html = '';
        if ($sale) {
            $sale_id = $sale->id;
            $html .= $this->getSaleDetails($sale_id);
        } else {
            $html .= '<p class="text-white">Not Found Any Sale Details for the Selected Table</p>';
        }
        return $html;
    }
    private function getSaleDetails($sale_id)
    {
        // list all saledetail
        $html = '';

        $saleDetails = SaleDetail::where('sale_id', $sale_id)->get();
        $sale = Sale::find($sale_id);
        $html .= '<div class="row text-white">
        <div class="col-5">
            <h4>Bill:' . $sale_id . '</h4>
        </div>
        <div class="col-4">
            <h4>TOTAL:$' . number_format($sale->total) . '</h4>
        </div>


    </div>';
        $html .= '<table class="table text-center table-hover">
        <thead class="text-white sticky-top">
            <tr>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total</th>
            <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($saleDetails as $saleDetail) :
            $html .= '
            <tr>
                <td>' . $saleDetail->product_name . '</td>
                <td>' . $saleDetail->price . '</td>
                <td>' . $saleDetail->quantity . '</td>
                <td>' . number_format(($saleDetail->price * $saleDetail->quantity), 2) . ' </td>';

            $html .= '<td><a data-id="' . $saleDetail->id . '" class="btn btn-danger btn-delete-saledetail"><i class="far fa-trash-alt"></a></td>';



            $html .= '</tr>';
        endforeach;
        $html .= '</tbody></table></div>';
        $html .= '
        <div class="row position-absolute bottom-0">
            <div class="col-4">
                <a class="btn text-white fw-bold" id="clear">CLEAR</a>
            </div>
            <div class=" col-4">
                <a class="btn text-white fw-bold" id="order">ORDER</a>
            </div>
            <div class="col-4">
                <a class="btn text-white fw-bold btn-success" id="pay">PAY</a>
            </div> ';

        return $html;
    }


    public function orderFood(Request $request)
    {
        $product = Product::find($request->product_id);
        $table_id = $request->table_id;
        $sale = Sale::firstWhere('table_id', $table_id);

        if (!$sale) {
            $sale = new Sale();
            $sale->table_id = $table_id;
            $sale_id = $sale->id;
            $sale->total = $request->quantity * $product->price;
            $sale->save();
            // update table status
            $table = Table::find($table_id);
            $table->status = "unavailable";
            $table->save();
        } else {
            $sale_id = $sale->id;
        }

        $saleDetail = new SaleDetail();
        $saleDetail->sale_id = $sale_id;
        $saleDetail->product_id = $product->id;
        $saleDetail->product_name = $product->name;
        $saleDetail->price = $product->price;
        $saleDetail->quantity = $request->quantity;
        $saleDetail->total = $product->price * $request->quantity;
        $saleDetail->save();
        //update total price in the sales table
        $sale->total += ($request->quantity * $product->price);
        $sale->save();

        $html = $this->getSaleDetails($sale_id);
        return $html;
    }



    public function deleteSaleDetail(Request $request)
    {

        $saleDetail_id = $request->saleDetail_id;
        $saleDetail = SaleDetail::find($saleDetail_id);
        $sale_id = $saleDetail->sale_id;
        $product_price = ($saleDetail->price * $saleDetail->quantity);
        $saleDetail->delete();
        //update total price
        $sale = Sale::find($sale_id);
        $sale->total = $sale->total - $product_price;
        $sale->save();
        // check if there any saledetail having the sale id
        $saleDetails = SaleDetail::where('sale_id', $sale_id)->first();
        if ($saleDetails) {
            $html = $this->getSaleDetails($sale_id);
        } else {
            $html = '<p class="text-white">Not Found Any Sale Details for the Selected Table</p>';
        }
        return $html;
    }
}