<?php

require_once dirname(__FILE__).'/indexCode.php';

?>

<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta name="author" content="Takashi Sano" />
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <title>Test Blog RSS Search</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/paging.js"></script>
        <script type="text/javascript">
            //calendar
            $(function() {
                $('#date').datepicker();
            });
        </script>
    </head>

    <body>
        <div class="wrap">
            <div class="header">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="headerTitle">Test Blog RSS Search</td>
                    </tr>
                </table>
            </div>

            <table border="0" cellspacing="0" cellpadding="0" class="message">
                <tr>
                    <td align="center"><?php echo $message ?></td>
                </tr>
            </table>

            <div class="container">
                <form id="rssSearch" action="index.php" method="GET">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width:110px;"><img src="img/arrow.gif">&nbsp;Search Criteria</td>
                            <td align="right">Date:&nbsp;</td>
                            <td style="width:100px;"><input type="text" name="date" value="<?php echo $queries['date'] ?>" style="width:80px;" id="date" onkeypress="searchCriteria(event.keyCode)";></td>
                            <td align="right">URL:&nbsp;</td>
                            <td style="width:220px;"><input type="text" name="url" value="<?php echo $queries['url'] ?>" style="width:200px;" onkeypress="searchCriteria(event.keyCode)";></td>
                            <td align="right">User Name:&nbsp;</td>
                            <td style="width:220px;"><input type="text" name="user" value="<?php echo $queries['user'] ?>" style="width:200px;" onkeypress="searchCriteria(event.keyCode)";></td>
                        </tr>
                        <tr>
                            <td style="height:2px;"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="right">Server No:&nbsp;</td>
                            <td><input type="text" name="server" value="<?php echo $queries['server'] ?>" style="width:80px;" onkeypress="searchCriteria(event.keyCode)";></td>
                            <td align="right">Entry No:&nbsp;</td>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><input type="text" name="entry" value="<?php echo $queries['entry'] ?>" style="width:80px;" onkeypress="searchCriteria(event.keyCode)";>&nbsp;</td>
                                        <td><input type="checkbox" name="entrymore" value="1" <?php echo $entrymoreChecked ?> id="entrymore">&nbsp;<label for="entrymore">or more</label></td>
                                    </tr>
                                </table>
                            </td>
                            <td align="right">Title:&nbsp;</td>
                            <td><input type="text" name="title" value="<?php echo $queries['title'] ?>" style="width:200px;" onkeypress="searchCriteria(event.keyCode)";></td>
                            <td><input type="button" id="search" value="Search" style="width:60px;" onclick="searchSubmit()"></td>
                        </tr>
                    </table>

                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="height:20px;"></td>
                        </tr>
                    </table>

                    <div style="display:<?php echo $noDataDisplay ?>;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="error">There is no data.</td>
                            </tr>
                        </table>
                    </div>

                    <div style="display:<?php echo $dataDisplay ?>;">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>Total Record: <?php echo number_format($totalRecord) ?></td>
                                <td style="width:40px;"></td>
                                <td>Page:&nbsp;<?php echo $pageList ?></td>
                                <td style="width:40px;"></td>
                                <td>Record Per Page:&nbsp;</td>
                                <td><?php echo $recordList ?></td>
                                <input type="hidden" name="page" id="page" value="<?php echo $queries['page'] ?>">
                            </tr>
                            <tr>
                                <td style="height:2px;"></td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" class="tableStyle" style="width:100%;">
                            <tr align="center" class="tableHeader">
                                <td style="width:8%;">Date</td>
                                <td style="width:26%;">URL</td>
                                <td style="width:16%;">Title</td>
                                <td style="width:50%;">Description</td>
                            </tr>
                            <?php foreach ($data as $row) { ?>
                            <tr class="tableContent" onmouseover="this.className='tableContent2'" onmouseout="this.className='tableContent'">
                                <td><?php echo date('m/d/Y', strtotime($row['Date'])) ?></td>
                                <td><?php echo htmlentities($row['Url'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?php echo htmlentities($row['Title'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?php echo htmlentities($row['Description'], ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </form>
            </div>

            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="height:100px;"></td>
                </tr>
            </table>
        </div>
    </body>
</html>
