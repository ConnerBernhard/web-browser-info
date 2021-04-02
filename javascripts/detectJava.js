/*

                detectJava.js v0.5.3
                By Eric Gerds   http://www.pinlady.net/PluginDetect/



 USAGE:
  1) This script works together with the PluginDetect script.
     When you download/generate the PluginDetect script, make sure that the
     "Java" checkbox is selected.
     See http://www.pinlady.net/PluginDetect/download/
     
  2) Insert the PluginDetect script into the <head> or <body> of your web page.

  3) Insert the output <div> into the <body> of your HTML page. This <div> will receive the
     plugin detection results:
        <div id="javaresult"></div>

  4) If you wish to specify the plugindetect <div>, then insert it into the <body>,
     anywhere BEFORE the plugin detection begins.
     This <div> temporarily holds any plugin object that is inserted into the web page,
     but only when needed for detection.
     For example:
        <div id="plugindetect" style="right:0px; top:0px; position:absolute;"></div>
     This step is optional, as PluginDetect will create and insert the <div> automatically 
     when needed.

  5) Insert this script AFTER the PluginDetect script, AFTER the output <div>,
     and AFTER the plugindetect <div> (assuming you specifed the plugindetect <div>).

  6) Get a copy of the "getJavaInfo.jar" jarfile. The jarfile is needed for Java detection.
     Adjust the value of the "jarfile" variable (given in the code below) to reflect the 
     jarfile name and path.

     Examples...

     If your web page is at      http://www.mysite.com/webpage.htm
     and you have the jarfile at http://www.mysite.com/getJavaInfo.jar
     then jarfile = "getJavaInfo.jar"  (relative path, relative to the web page)

     If your web page is at       http://www.mysite.com/webpage.htm
     and you have the jarfile at  http://www.mysite.com/stuff/getJavaInfo.jar
     then jarfile = "stuff/getJavaInfo.jar"   (relative path, relative to the web page)
     or   jarfile = "/stuff/getJavaInfo.jar"  (absolute path)

  7) Feel free to change this script, remove comments, etc... to fit your own needs.


*/


(function(){

var $ = PluginDetect,

 minVersion = "1,7,0,50",      // minimum version of Java we are trying to detect

// The path of the jarfile can be relative or absolute. 
// Only the very first Java PluginDetect command that is executed
// needs to have the jarfile input argument. You do not have to specify this input arg in
// any subsequent Java PluginDetect commands.
 jarfile = "../files/getJavaInfo.jar",

// If the verifyTags input argument is not specified or is null, then PluginDetect assumes
// a default value. Only the very first Java PluginDetect command that is executed
// would need to have the verifyTags input argument, if at all. You do not have to specify
// this input arg in any subsequent Java PluginDetect commands.
 verifyTags = null,

// output <div>. Detection results are placed in this <div>.
 out = document.getElementById("javaresult");



// Add text to output node
var docWrite = function(text){
     if (out){
        if (text){
          text = text.replace(/&nbsp;/g,"\u00a0");
          out.appendChild(document.createTextNode(text));
        };
        out.appendChild(document.createElement("br"));
     };
};  // end of function



// If we use the onBeforeInstantiate method, then use it BEFORE any other PluginDetect method.
// var F = function(){};
// if ($.onBeforeInstantiate) $.onBeforeInstantiate("Java", F);




// This event handler writes the detection results to the web page
function displayResults($){

  // Display the highest installed Java version.
  if ($.getVersion) ;


  // Test whether Java is installed or not.
  //
  // Note that $.isMinVersion("Java") is equivalent to $.isMinVersion("Java", "0").
  if ($.isMinVersion)
  {
  
   // Check if some minimum Java version is installed
    var JavaStatus = $.isMinVersion("Java", minVersion);

    if (JavaStatus == 1)
      docWrite("" + $.getVersion("Java"))

    else if (JavaStatus == 0) docWrite("Version is unknown")

    else if (JavaStatus == -0.1) docWrite("Version is < " + $.getVersion("Java"))

    else if (JavaStatus == -0.2) docWrite("Disabled")

    // if this function is called by $.onDetectionDone(), then detection has completed,
    // and so -.5/+.5 would not occur.
    else if (JavaStatus == -0.5 || JavaStatus == 0.5)
      docWrite("requires NOTF detection.")

    else if (JavaStatus == -1) docWrite("Disabled")

    else if (JavaStatus == -3) docWrite("Error...");

  };
};  // end of displayResults()




// Start Java plugin detection, using the jarfile if needed.
// When Java detection has been completed, then call displayResults().
$.onDetectionDone("Java", displayResults, jarfile, verifyTags);



})();   // end of anonymous function

