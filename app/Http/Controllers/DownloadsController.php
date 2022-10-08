<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use Illuminate\Http\Request;

class DownloadsController extends Controller
{
     /**
     * download as a pdf the marks of a specified student 
     *
     * @param  int $year
     * @param  int $semester
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function download_pdf_marks_students(int $year, int $semester, int $id)
    {
        try
        {
            $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape');
            $pdf->loadHtml($this->view_pdf($year, $semester, $id));

            return $pdf->stream();
        } 
        catch(\Exception $e)
        {
            return ["error" => $e];
        }
    }

    public function view_pdf(int $year, int $semester, int $id)
    {
        $marks = Mark::all()->where('student_id', $id)->where('semester', $semester);
        $all_marks = [];
        foreach ($marks as $mark) 
        {
            $module = $mark->module;

            $year_mark = $mark->year;
            if ($year_mark == $year) 
            {
                $all_marks []= [
                    'marks'=> $mark
                ];
            }
        }
        
        // dd($all_marks);
        $output = '
        <head>
        <meta charset="utf-8">
        <title>Marks</title>
        </head>
        <body>
        <div class="wrapper mt-lg-5">
            <div class="sidebar-wrapper">
                <div class="profile-container">
        ';
        // foreach($all_marks as $mark)
        // {
        //     $output .= '<h2 class="name">'.$mark->module.'</h2>';
    

        //     $output .= '</div>';
        //     $output .= '<div class="contact-container container-block">
        //         <ul class="list-unstyled contact-list">                    
        //             <li class="address"><i class="fa-brands fa-location"></i>'.$mark->score.'</li>
        //         </ul>
        //     </div>';
        // }

        $output .= 'test';
        $output .= '
        </body>';
    
        return $output;
    }

}
