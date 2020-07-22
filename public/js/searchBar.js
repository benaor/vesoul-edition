// Ajax for searchBar !
$(document).ready(function () {
    $('#searchBar').keyup(function () {
        var searchBarValue = $(this).val();


        if (searchBarValue != "") {
            $.ajax({
                type: 'GET',
                url: '/search/' + searchBarValue,
                success: function (data, statusText, response) {
                    console.log(response.status)
                    //si je trouve un livre qui correspond 
                    if (response.status == 200) {

                        document.getElementById('searchBarResult').innerHTML = "";

                        for (let i = 0; i < 5; i++) {

                            let searchBook = "<a href='/book/" + data.books[i].id + "' class='text-dark'> <div class='p-3 bg-white  linkResult'> " + data.books[i].title + "</div> </a>";
                            document.getElementById('searchBarResult').insertAdjacentHTML('beforeend', searchBook);
                            ;

                        }

                        console.log(data);

                        //Si aucun livre dans la BDD ne correspond
                    } else {
                        console.log(data);
                        document.getElementById('searchBarResult').innerHTML = "<p> aucun livre trouvé </p>";
                    }
                }
            })
        } else {
            document.getElementById('searchBarResult').innerHTML = "";
        }
    })
});
