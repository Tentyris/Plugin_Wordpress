function getComments() {
    $.ajax({
       url: 'https://youtube.googleapis.com/youtube/v3/commentThreads',
       method: 'GET',
       headers: {
           "Authorization":"Bearer",
           "Accept":"application/json"
       },
       data: "part=id%2C%20snippet&maxResults=10&order=relevance&videoId=dQw4w9WgXcQ&key=AIzaSyDIXzmnJ_QPZg-eTtb7PB32OBG8PzA26TU"
    }).done(function (data) {
        console.log(data);
    });
}