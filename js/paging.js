function searchSubmit()
{
    $('#page').val('1');
    $('#rssSearch').submit();
}

function searchCriteria(code)
{
    if (code === 13) //enter key
        searchSubmit();
}

function changePage(page)
{
    $('#page').val(page);
    $('#rssSearch').submit();
}

function changeRecord()
{
    $('#page').val('1');
    $('#rssSearch').submit();
}

function changePagePrev(operator)
{
    var currentPage = $('#page').val();
    $('#page').val(Number(currentPage) - 1);
    $('#rssSearch').submit();
}

function changePageNext()
{
    var currentPage = $('#page').val();
    $('#page').val(Number(currentPage) + 1);
    $('#rssSearch').submit();
}

