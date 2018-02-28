

var searchIndex = [];


$(document).ready(function()
                      {
                       
                             $.ajax({
                                  type : 'GET',
                                  url  : '/ajax/AllKeywords',
                                 
                                 
                                 success: function(data) {
                                    
                                    for (var i = 0; i < data.keywords.length; i++)
                                     {
                                       searchIndex.push(data.keywords[i].keyword) ;
                                     } 
                                    

                                    },
                                      error :  function(data)
                                      {
                                          alert("error");
                                      }
                              });


                      });





var input = document.getElementById("searchBox"),
    ul = document.getElementById("searchResults"),
    inputTerms, termsArray, prefix, terms, results, sortedResults;


var search = function() {
  inputTerms = input.value.toLowerCase();
  results = [];
  termsArray = inputTerms.split(' ');
  prefix = termsArray.length === 1 ? '' : termsArray.slice(0, -1).join(' ') + ' ';
  terms = termsArray[termsArray.length -1].toLowerCase();
  
  for (var i = 0; i < searchIndex.length; i++) {
    var a = searchIndex[i].toLowerCase(),
        t = a.indexOf(terms);
    
    if (t > -1) {
      results.push(a);
    }
  }
  
  evaluateResults();
};

var evaluateResults = function() {
  if (results.length > 0 && inputTerms.length > 0 && terms.length !== 0) {
    sortedResults = results.sort(sortResults);
    appendResults();
  } 
  else if (inputTerms.length > 0 && terms.length !== 0) {
    ul.innerHTML = '<strong> Aucun résultat trouvé </strong>' ;
    
  }
  else if (inputTerms.length !== 0 && terms.length === 0) {
    return;
  }
  else {
    clearResults();
  }
};

var sortResults = function (a,b) {
  if (a.indexOf(terms) < b.indexOf(terms)) return -1;
  if (a.indexOf(terms) > b.indexOf(terms)) return 1;
  return 0;
}

var appendResults = function () {
  clearResults();
  
  for (var i=0; i < sortedResults.length && i < 5; i++) {
    var li = document.createElement("li"),
        result = prefix 
          + sortedResults[i].toLowerCase().replace(terms, '<strong>' 
          + terms 
          +'</strong>');
    
    li.innerHTML = result;

    //by raouf 
      
      li.addEventListener('click', function(result)
       {
          
          //  Oops sorry forr using Jquery  haha  ! 
          input.value = $(this).text() ;    
          clearResults();

       },false);

    //

    ul.appendChild(li);
  }
  
  if ( ul.className !== "term-list") {
    ul.className = "term-list";
  }
};

var clearResults = function() {
  ul.className = "term-list hidden";
  ul.innerHTML = '';
};
  
input.addEventListener("keyup", search, false);

