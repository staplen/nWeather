$(function() {

  var appData = {
    heading1: $('#weather-container h2'),
    heading2: $('#weather-container h3'),
    searchInput: $('#location-input'),
    weatherContainer: $('#weather-container'),
    autocompleteContainer: $('#autocomplete-container'),
    resultsList: $('#autocomplete-container > ul'),
    currentCity: '',
    currentState: '',
    currentLocation: '',
    locationData: []
  }

  var appState = {
    selectedResult: -1,
    selectedResultQuery: null
  }

  if (navigator.geolocation) {
    var timeoutVal = 10 * 1000 * 1000;
    navigator.geolocation.getCurrentPosition(
      displayPosition, 
      displayError,
      { enableHighAccuracy: false, timeout: timeoutVal, maximumAge: 1000 }
    );
  }
  else {
    displayError(null);
  }

  function displayPosition(position) {
    var query = position.coords.latitude + ',' + position.coords.longitude;
    queryLocation(query);
  }

  function displayError(error) {
    appData.heading1.text('Your location could not be determined');
    appData.searchInput.val('').css('opacity',1);
  }

  function queryLocation(query) {
    $.get( '/api/weather.php?query='+query, function( data ) {
      if (data.response.error) {
        appData.heading1.text(data.response.error.description);
      }
      else if (!data.location) {
        appData.heading1.text('Please be more specific in your location');
      }
      else {
        appData.city = data.location.city ? data.location.city : '';
        appData.state = data.location.state ? data.location.state : '';
        var comma = appData.city && appData.state ? ', ' : '';
        appData.currentLocation = appData.city+comma+appData.state;
        renderWeather(data.current_observation);
      }
      appData.searchInput.val('').removeAttr('disabled').css('opacity',1);
    },'json');
  }

  function quickQuery(query) {
    $.get( '/api/conditions.php?query='+query, function( data ) {
      if (data.response.error) {
        appData.heading1.text(data.response.error.description);
      }
      else {
        renderWeather(data.current_observation);
      }
      appData.searchInput.val('').removeAttr('disabled').css('opacity',1);
    },'json');
  }

  function renderWeather(observation) {
    appState.selectedResultQuery = null;
    document.title = 'Weather | ' + appData.currentLocation;
    var weather = observation.weather ? observation.weather : '';
    var temp_f = observation.temp_f ? Math.round(observation.temp_f) + '&deg;F' : '';
    var comma = weather && temp_f ? ', ' : '';
    var currentWeather = weather+comma+temp_f;
    appData.heading1.html(currentWeather);
    appData.heading2.text(appData.currentLocation);
  }


  $('#search-form').submit(function(e){
    e.preventDefault();
    if (appState.selectedResultQuery) {
      $('li.selected > a',appData.resultsList).trigger('click');
    }
    else {
      var query = encodeURIComponent($(appData.searchInput).val());
      if (query.length > 0) {
        appData.resultsList.html('');
        appData.heading1.text('Searching...');
        appData.heading2.html('&nbsp;');
        appData.searchInput.attr('disabled','').css('opacity',0.2).blur();
        queryLocation(query);
      }
    }
  });

  function processSearchText() {
    $('body').addClass('autocomplete-active');
    var query = encodeURIComponent($(appData.searchInput).val());
    $('li',appData.resultsList).remove();
    appData.locationData = [];
    appState.selectedResult = -1;
    $.get( '/api/autocomplete.php?query='+query, function( data ) {
      var i = 0;
      _.each(data.RESULTS,function(result) {
        if (i < 5 && result.type === 'city' && !appData.locationData[result.zmw]) {
          var listItem = $(document.createElement('li'));
          listItem.html('<a href="http://www.wunderground.com'+result.l+'" target="_blank" data-zmw="'+result.zmw+'" id="'+result.zmw+'">'+result.name+'</a>');
          appData.locationData[result.zmw] = result;
          $('a',listItem).click(processAutoClick);
          listItem.hover(function() {
            $(this).siblings().removeClass('selected');
            $(this).toggleClass('selected');
            // TODO: appStates.selectedResult = array index of this item somehow
            appData.searchInput.val($(this).text());
          },
          function() {
            $(this).toggleClass('selected');
          });
          appData.resultsList.append(listItem);
          i++;
        }
      });
    },'json');
  }

  appData.searchInput.keyup(function(e) {

    switch(e.which) {
      case 40:
        // down key
        e.preventDefault();
        var results = $('li',appData.resultsList);
        appState.selectedResult++;
        appState.selectedResult = appState.selectedResult > results.length - 1 ? results.length - 1 : appState.selectedResult;
        $(results[appState.selectedResult]).addClass('selected');
        appData.searchInput.val($(results[appState.selectedResult]).text());
        appState.selectedResultQuery = $('a',results[appState.selectedResult]).data('zmw');
        $(results[appState.selectedResult-1]).removeClass('selected');
        break;
      case 38:
        // up key
        e.preventDefault();
        var results = $('li',appData.resultsList);
        appState.selectedResult--;
        appState.selectedResult = appState.selectedResult < 0 ? 0 : appState.selectedResult;
        $(results[appState.selectedResult]).addClass('selected');
        appData.searchInput.val($(results[appState.selectedResult]).text());
        appState.selectedResultQuery = $('a',results[appState.selectedResult]).data('zmw');
        $(results[appState.selectedResult+1]).removeClass('selected');
        break;
      default:
        processSearchText();
    }

  });

  function processAutoClick(e) {
    console.log('processAutoClick');
    e.preventDefault();
    var locationData = appData.locationData[$(this).data('zmw')];
    appData.currentLocation = locationData.name;
    appData.resultsList.html('');
    appData.heading1.text('Loading...');
    appData.heading2.html('&nbsp;');
    appData.searchInput.attr('disabled','').css('opacity',0.2).blur();
    quickQuery(locationData.l);
  }

  appData.searchInput.on('blur',function() {
    $('body').removeClass('autocomplete-active');
  });

});