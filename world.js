document.addEventListener('DOMContentLoaded', function(){
    var lookupB = document.getElementById('lookup');
    var uInput =  document.getElementById('country');
    var resDiv =  document.getElementById('result');

    lookupB.addEventListener('click', function(){
        var newSearch = uInput.value //grabbing user input

        //here we will open an ajax connection to sort of ask the php for data from database

        fetch('world.php?country=' + encodeURIComponent(newSearch))
            .then(response => response.text())
            .then(data => {
                resDiv.innerHTML = data; //printing obtained data into result div
            })
            .catch(error => {
                console.error("Encountered error fetching your data:", error);
            })

    }); //end of event listener for when button is clicked






}); //end of content loading