(function(){var A=scheduler._pre_render_events_line;scheduler._pre_render_events_line=function(I,C){for(var E=0;E<I.length;E++){var H=I[E];if(!H._timed){var D=this._lame_copy({},H);D.start_date=new Date(D.start_date);var G=scheduler.date.add(H.start_date,1,"day");G=scheduler.date.date_part(G);if(H.end_date<G){D.end_date=new Date(H.end_date)}else{D.end_date=G;if(this.config.last_hour!=24){D.end_date=scheduler.date.date_part(new Date(D.start_date));D.end_date.setHours(this.config.last_hour)}}var F=false;if(D.start_date<this._max_date&&D.end_date>this._min_date&&D.start_date<D.end_date){I[E]=D;F=true}if(D.start_date>D.end_date){I.splice(E--,1)}var K=this._lame_copy({},H);K.end_date=new Date(K.end_date);if(K.start_date<this._min_date){K.start_date=new Date(this._min_date)}else{K.start_date=this.date.add(H.start_date,1,"day")}K.start_date.setHours(this.config.first_hour);K.start_date.setMinutes(0);if(K.start_date<this._max_date&&K.start_date<K.end_date){if(F){I.splice(E+1,0,K)}else{I[E--]=K;continue}}}}var J=(this._drag_mode=="move")?false:C;return A.call(this,I,J)};var B=scheduler.get_visible_events;scheduler.get_visible_events=function(){return B.call(this,false)};scheduler.attachEvent("onBeforeViewChange",function(E,C,F,D){scheduler._allow_dnd=(F=="day"||F=="week");return true})})();