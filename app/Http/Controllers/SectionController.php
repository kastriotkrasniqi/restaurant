<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Table;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return view('order.section', compact('sections'));
    }



    public function getTablesById($id)
    {
        $tables = Table::where('section_id', $id)->get();
        $html = '';
        foreach ($tables as $table) {
            $html .= '<a href="/order/getTableId/' . $table->id . '"class="btn col-2 bg-success rounded-3 text-white text-center  pt-2  produkti" id="table" >';
            $html .= '<p class="fs-6 fw-bold text-decoration-none text-white" >' . $table->name . '</p>';
            $html .= '</a>';
        }

        return $html;
    }
}