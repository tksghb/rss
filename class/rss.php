<?php

require_once dirname(__FILE__).'/database.php';

class rss
{
    public function selectRss($type, $criterias) //type:1=total 2=data
    {
        $db = database::getConnection();

        $sqlCount = 'SELECT COUNT(*) AS Count ';

        $sqlItems = 'SELECT Date,
                            Url,
                            Title,
                            Description ';

        $sqlBody = ' FROM Rss
                    WHERE RssID > 0 ';

        //search criteria
        if (!empty($criterias['date']))
        {
            $sqlBody .= ' AND DATE_FORMAT(Date, \'%m/%d/%Y\') = ? ';
        }
        if (!empty($criterias['url']))
        {
            $sqlBody .= ' AND Url LIKE ? ';
            $criterias['url'] = '%'.$criterias['url'].'%'; //add % for partial match
        }
        if (!empty($criterias['user']))
        {
            $sqlBody .= ' AND UserName = ? ';
        }
        if (!empty($criterias['server']))
        {
            $sqlBody .= ' AND ServerNo = ? ';
        }
        if (!empty($criterias['entry']))
        {
            if ($criterias['entrymore'] === '1')
            {
                $sqlBody .= ' AND EntryNo >= ? ';
                $criterias['entrymore'] = ''; //delete because not needed for parameter execute(array)
            }
            else
            {
                $sqlBody .= ' AND EntryNo = ? ';
            }
        }
        if (!empty($criterias['title']))
        {
            $sqlBody .= ' AND Title LIKE ? ';
            $criterias['title'] = '%'.$criterias['title'].'%'; //add % for partial match
        }

        $sqlBody .= ' ORDER BY Date DESC ';

        if ($type === '1') //total record count
        {
            //delete because not needed for parameter execute(array)
            $criterias['page'] = '';
            $criterias['record'] = '';

            //remove empty in array
            $criterias = array_filter($criterias);

            $stmt = $db->prepare($sqlCount.$sqlBody);
            $stmt->execute(array_values($criterias));
            $result = $stmt->fetch();
            $result = $result['Count'];
        }
        else //data
        {
            $startRow = $criterias['record'] * ($criterias['page'] - 1);
            $sqlBody .= ' LIMIT ' . $criterias['record'] . ' OFFSET ' . $startRow;

            //delete because not needed for parameter execute(array)
            $criterias['page'] = '';
            $criterias['record'] = '';

            //remove empty in array
            $criterias = array_filter($criterias);

            $stmt = $db->prepare($sqlItems.$sqlBody);
            $stmt->execute(array_values($criterias));
            $result = $stmt->fetchAll();
        }

        return $result;
    }    

    public function insertRss($rssValues)
    {
        $db = database::getConnection();

        $sql = 'INSERT INTO Rss
                 (Date, Title, Description, Url, UserName, ServerNo, EntryNo, CreateDate) 
                 VALUES
                 (?, ?, ?, ?, ?, ?, ?, NOW()) ';

        $stmt = $db->prepare($sql);
        $stmt->execute(array_values($rssValues));
    }

    public function isRssExistance($date, $link)
    {
        $isRssExistance = false;

        $db = database::getConnection();

        $sql = 'SELECT RssID
                   FROM Rss
                  WHERE Date = ?
                    AND Url = ? ';

        $stmt = $db->prepare($sql);
        $stmt->execute(array($date, $link));
        if ($stmt->fetch() !== false)
        {
            $isRssExistance = true;
        }

        return $isRssExistance;
    }

    public function deleteRss($criteria)
    {
        $db = database::getConnection();

        $sql = 'DELETE FROM Rss
                 WHERE DATE_FORMAT(Date, \'%Y-%m-%d %H.%i.%s\') < ? ';

        $stmt = $db->prepare($sql);
        $stmt->execute(array($criteria));
    }

    public function validateSelecrtRss($criterias)
    {
        $message = '';

        if (!empty($criterias['date']))
        {
            $date = explode('/', $criterias['date']);

            if (count($date) !== 3 || !checkdate($date[0], $date[1], $date[2]))
            {
                $message .= 'Please enter valid date in Date.<br>';
            }
        }

        if (!empty($criterias['server']) && !is_numeric($criterias['server']))
            $message .= 'Please enter number in Server No.<br>';

        if (!empty($criterias['entry']) && !is_numeric($criterias['entry']))
            $message .= 'Please enter number in Entry No.<br>';

        if (empty($criterias['entry']) && $criterias['entrymore'] === '1')
            $message .= 'Please enter number in Entry No.<br>';

        return $message;
    }
}


