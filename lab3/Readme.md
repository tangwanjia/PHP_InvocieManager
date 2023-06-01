What changes did you make when refactoring the project?
Firstly, I copied and pasted all the data to index.php from template, then use $_GET to grab the status data, I also build up switch case to change the pages in the navagation bar.

In your own words, what are the guidelines for knowing when to use $_POST over query strings and $_GET?
$_GET is more like to grab the data to server and $_POST is more like to push the date to the client side.

What are some limitations to using sessions for persistent data? What could be done to overcome those limitations?
it can be add date to the form but cannot delete the data added. 
probably database would be better tool to overcome this limitations.
