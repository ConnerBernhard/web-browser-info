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

var out = document.getElementById("detectQuickTime_output");  // node for output text

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


// Object that holds all data on the plugin
var P = {name:"QuickTime", status:-1, version:null, minVersion:"7,0,0,0"};


var $=PluginDetect;
   
// If we use the onBeforeInstantiate method, then use it BEFORE any other PluginDetect method.
// var F = function(){alert("onBeforeInstantiate() works")};
// if ($.onBeforeInstantiate) $.onBeforeInstantiate("QuickTime", F);


if ($.getVersion)
{
  P.version = $.getVersion(P.name);
  
};


if ($.isMinVersion)
{
  P.status = $.isMinVersion(P.name, P.minVersion);
  docWrite("" + getStatusMsg(P));
};
})();    // end of function


