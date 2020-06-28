// Ajax for searchBar !
$(document).ready(function(){
    $('#searchBar').keyup(function(){
        var searchBarValue = $(this).val();
        console.log(searchBarValue);

        if(searchBarValue != ""){
            $.ajax({
                type: 'GET',
                url: '/search',
                data: 'book='+searchBarValue,
                success: function(data){

                    //si je trouve un livre qui correspond 
                    if(data != ""){
                        $('#searchBarResult').append(data);

                    //Si aucun livre dans la BDD ne correspond
                    } else {
                        document.getElementById('searchBarResult').innerHTML = "<p> aucun livre trouvé </p>";
                    }
                }
            })
        }
    })
});