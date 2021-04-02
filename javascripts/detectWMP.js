// Detect the plugin
(function(){
  
 // Return text message based on plugin detection result
 var getStatusMsg = function(obj)
 {
   if (obj.status==1) return "" + obj.version;
   if (obj.status==0) return "Detected version unknown";
   if (obj.status==-0.1) return "" + obj.version;
   if (obj.status==-0.2) return "Disabled";
   if (obj.status==-1) return "Not Detected";
   if (obj.status==-3) return "Disabled";
   return "unknown";
 };   // end of function

 var out = document.getElementById("detectWMP_output");  // node for output text

 // Add text to output node
 var docWrite = function(text)
 {
     if (out)
     {
        if (text)
        {
          text = text.replace(/&nbsp;/g,"\u00a0");
          out.appendChild(document.createTextNode(text));
        };
        out.appendChild(document.createElement("br"));
     };
 };  // end of function



 // Object that holds all data on the plugin
 var P = {name:"WindowsMediaPlayer", mime:"", status:-1, version:null, minVersion:"11,0,0,0"};

 var $ = PluginDetect, 

   // The 'instantiate' input argument only affects non-Internet Explorer browsers.
   // 
   // When 'instantiate' is undefined or false, then PluginDetect will detect
   // the presence of the plugin. However, the plugin version may not be detected,
   // since the version # is often not present in the navigator.plugins[] array.
   // There should not be any security popup messages generated by any browsers
   // during this plugin detection.
   //
   // When 'instantiate' is true, then an instance of the plugin will be inserted into
   // the DOM. This may cause a security popup message to appear in some browsers 
   // asking for permission to run the plugin (if the plugin is outdated or insecure).
   // If or when the plugin runs, then this plugin instance will be queried by
   // PluginDetect to get the exact plugin version.
   //
   // Note: For Internet Explorer, the plugin version will always be detected regardless
   // of the value of 'instantiate'.
   instantiate=false;



 // Detect WMP Version
 if ($.getVersion)
 {
    P.version = $.getVersion(P.name, instantiate);
    
 };
   

 // Detect Plugin Status
 if ($.isMinVersion)
 {
   P.status = $.isMinVersion(P.name, P.minVersion, instantiate);
   docWrite("" + getStatusMsg(P));
   
 };

})(); // end of function

