// Ajax for searchBar !
$(document).ready(function(){
    $('#searchBar').keyup(function(){
        var searchBarValue = $(this).val();
        

        if(searchBarValue != ""){
            $.ajax({
                type: 'GET',
                url: '/search/'+searchBarValue,
                success: function(data, statusText, response){
console.log(response.status)
                    //si je trouve un livre qui correspond 
                    if(response.status == 200){
                        document.getElementById('searchBarResult').innerHTML =
                        "<a href='/book/" + data.books[0].id + "'>"+ data.books[0].title +'</a>';

                        console.log(data);
                        
                    //Si aucun livre dans la BDD ne correspond
                    } else {
                        console.log(data);
                        document.getElementById('searchBarResult').innerHTML = "<p> aucun livre trouvé </p>";
                    }
                }
            })
        }
    })
});