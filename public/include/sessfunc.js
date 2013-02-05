var xmlhttp ;

function result_langCheck( ) {
    if ( ( xmlhttp.readyState == 4 ) && ( xmlhttp.status == 200 ) ) {
        if ( xmlhttp.responseText == "OK" ) {
            // ログイン情報が格納できたときの処理
        }
        else {
            // ログイン情報の格納に失敗したときの処理
        }
    }
}
function langCheck( ) {
    var langs  = document.getElementById( 'LANGS' ).value ;
    xmlhttp = createXmlHttp( result_loginCheck ) ;
    if ( xmlhttp ) {
        var postdata = new String( ) ;
        postdata = postdata.concat( "&langs=" ) ;
        postdata = postdata.concat( langs ) ;
        xmlhttp.open( 'post', 'langCheck.php', true ) ;
        xmlhttp.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" ) ;
        xmlhttp.send( postdata ) ;
    }
}
function result_getSessionInfo( ) {
    if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
        if ( xmlhttp.responseText < 0 ) {
            // セッションデータの取得に失敗したときの処理
        }
        else {
            // セッションデータが取得できたときの処理
        }
    }
}
function getSessionInfo( ) {
    xmlhttp = createXmlHttp( result_getSessionInfo ) ;
    if ( xmlhttp ) {
        xmlhttp.open( 'post', 'getSessionInfo.php', true ) ;
        xmlhttp.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" ) ;
        xmlhttp.send( null ) ;
    }
}
window.onload = function( ) {
    getSessionInfo( ) ;
}

