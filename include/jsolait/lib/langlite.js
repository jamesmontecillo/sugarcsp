/*
  Copyright (c) 2004 Jan-Klaas Kollhof
  
  This file is part of the JavaScript o lait library(jsolait).
  
  jsolait is free software; you can redistribute it and/or modify
  it under the terms of the GNU Lesser General Public License as published by
  the Free Software Foundation; either version 2.1 of the License, or
  (at your option) any later version.
 
  This software is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Lesser General Public License for more details.
 
  You should have received a copy of the GNU Lesser General Public License
  along with this software; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
    FOR SUGARCRM
    This is a stripped down version of lang.php, all it does is:
    convert JavaScript objects to  JSON (see json.org).
    but *does not* add toJSON() function to every class that is derived from Object
*/
Module("langlite", "0.3.7", function(mod){
   
    mod.JSONParser=Class("JSONParser", function(publ, supr){
        publ.init=function(){
            this.libs = {};
        }
        
        publ.addLib = function(obj, name, exports){
            if(exports == null){
                this.libs[name] = obj;
            }else{
                for(var i=0;i<exports.length;i++){
                    this.libs[name + "." + exports[i]] = obj[exports[i]];
                }
            }
        }
                
        publ.objToJson=function(obj){
            if(obj == null){
                return "null";
            }else{
                return mod.objToJson(obj);
            }
        }
    })
        
    mod.parser = new mod.JSONParser();
    
    /**
        Turns JSON code into JavaScript objects.
        @param src  The source as a String.
    */
    mod.jsonToObj=function(src){
        return mod.parser.jsonToObj(src);
    }
    
    var json_types = new Object();
                                                                                             
    json_types['object'] = function(obj){
        var v=[];
        for(attr in obj){
            if(typeof obj[attr] != "function"){
                v.push('"' + attr + '": ' + mod.objToJson(obj[attr]));
            }
        }
        return "{" + v.join(", ") + "}";
    }
                                                                                             
    json_types['string'] = function(obj){
        var s = '"' + obj.replace(/(["\\])/g, '\\$1') + '"';
        s = s.replace(/(\n)/g,"\\n");
        return s;
    }
                                                                                             
    json_types['number']  = function(obj){
        return obj.toString();
    }

    json_types['boolean'] = function(obj){
        return obj.toString();
    }

    json_types['date'] = function(obj){
        var padd=function(s, p){
            s=p+s
            return s.substring(s.length - p.length)
        }
        var y = padd(obj.getUTCFullYear(), "0000");
        var m = padd(obj.getUTCMonth() + 1, "00");
        var d = padd(obj.getUTCDate(), "00");
        var h = padd(obj.getUTCHours(), "00");
        var min = padd(obj.getUTCMinutes(), "00");
        var s = padd(obj.getUTCSeconds(), "00");
                                                                                             
        var isodate = y +  m  + d + "T" + h +  ":" + min + ":" + s
        
        return '{"jsonclass":["sys.ISODate", ["' + isodate + '"]]}';
    }

    json_types['array'] = function(obj){
        var v = [];
        for(var i=0;i<obj.length;i++){
            v.push(mod.objToJson(obj[i])) ;
        }
        return "[" + v.join(", ") + "]";
    }


    mod.objToJson=function(obj){
      if ( typeof(obj) == 'undefined')
      {
      	return '';
      }
      if ( typeof(json_types[typeof(obj)]) == 'undefined')
      {
      	alert('class not defined for toJSON():'+typeof(obj));
      }
      return json_types[typeof(obj)](obj);
    }

        
    mod.test=function(){
        try{
            print(mod.objToJson(['sds', -12377,-1212.1212, 12, '-2312']));
        }catch(e){
            print(e.toTraceString());
        }
        
    }
    
})

