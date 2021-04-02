(function(){


 // Return text message based on plugin detection result
 var getStatusMsg = function(obj){
   if (obj.status==1) return "" + obj.version;
   if (obj.status==0) return "installed version unknown";
   if (obj.status==-0.1) return "" + obj.version;
   if (obj.status==-0.2) return "not enabled";
   if (obj.status==-1) return "not installed";
   if (obj.status==-3) return "not enabled";
   return "unknown";
 };   // end of function

 var out = document.getElementById("detectFlash_output");  // node for output text

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
   var P = {name:"Flash", status:-1, version:null, minVersion:"11,7,0,0"};


   var $=PluginDetect,
   
   
   instantiate=false;


   if ($.getVersion)
   {
      P.version = $.getVersion(P.name, instantiate);
      
   };


   if ($.isMinVersion){
      P.status = $.isMinVersion(P.name, P.minVersion, instantiate);
      docWrite("" + getStatusMsg(P));
   };


   // The 'instantiate' input argument only applies to non-IE browsers
   if (P.version && !$.browser.isIE)
   {
      var tmp = P.version.split(/[\.\_,\-]/g);
      if ( parseInt(tmp[3] || "0", 10) === 0 )
      {
         docWrite("");
         docWrite("Note: to obtain the last digit of the plugin version, you will need to use the " +
            "'instantiate' input argument.");
         docWrite("You will also have to give your browser permission to run the plugin.");
      };

   };
})();   // end of function



