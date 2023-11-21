document.addEventListener('DOMContentLoaded', function(){
    var lookupB = document.getElementById('lookup'); //first button
    var nlookupB = document.getElementById('nlookup'); //second button
    var uInput =  document.getElementById('country'); //user input
    var resDiv =  document.getElementById('result'); //result div

    lookupB.addEventListener('click', function(){
        var newSearch = uInput.value //grabbing user input

        //here we will open an ajax connection to sort of ask the php for country data from database

        fetch('world.php?country=' + encodeURIComponent(newSearch))
            .then(response => response.text())
            .then(data => {
                resDiv.innerHTML = data; //printing obtained data into result div
            })
            .catch(error => {
                console.error("Encountered error fetching your data:", error);
            })

    }); //end of event listener for when button is clicked

    nlookupB.addEventListener('click', function(){  //add eventlistener to second button
        var newSearch = uInput.value  //again, grabbing user input

        //here we will open an ajax connection to sort of ask the php for city data from database

        fetch('world.php?country=' + encodeURIComponent(newSearch) + '&lookup=cities')
            .then(response => response.text())
            .then(data =>{  //here we got new data for request
                resDiv.innerHTML = data  //we appropriately copy our data into the result div
            })
            .catch(error => {  //error handling in case we don't get this data or something happened
                console.error("Encountered error fetching your data:", error);
            })

    });  //end of second eventlistener







}); //end of content loading