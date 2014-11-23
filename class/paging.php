<?php

class paging
{
    public static function getPageList($tatalRecord, $record, $page)
    {
        $lastPage = ceil($tatalRecord / $record);

        $startPage = 1;
        if ($lastPage > 10 && $page > 6)
            $startPage = $page - 5;

        $pageCount = $lastPage;
        if ($lastPage - $startPage > 10)
            $pageCount = $startPage + 9;

        $list = '';

        if ($page > 1)
            $list .= '&nbsp;<a href="javascript:changePagePrev();">Prev</a>&nbsp;';

        for ($i = $startPage; $i <= $pageCount; $i++)
        {
            if ($i == $page)
                $list .= '&nbsp;'.$i.'&nbsp;';
            else
                $list .= '&nbsp;<a href="javascript:changePage('.$i.')">'.$i.'</a>&nbsp;';
        }

        if ($page < $lastPage)
            $list .= '&nbsp;<a href="javascript:changePageNext();">Next</a>&nbsp;';

        return $list;
    }

    public static function getRecordList($selectedValue)
    {
        $record = array(25, 50, 100, 500, 1000);

        $selected = '';
        $list = '<select name="record" onchange="changeRecord()">';

        for ($i = 0; $i < count($record); $i++)
        {
            if ($record[$i] == $selectedValue)
                $selected = ' selected';
            else
                $selected = '';

            $list .= '<option value="'.$record[$i].'"'.$selected .'>'.$record[$i].'</option>';
        }

        $list .= '</select>';

        return $list;
    }
}


