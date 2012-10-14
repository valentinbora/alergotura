scheduler.grid={sort_rules:{"int":function(B,A,C){return B[C]*1<A[C]*1?1:-1},str:function(B,A,C){return B[C]<A[C]?1:-1},date:function(B,A,C){return new Date(B[C])<new Date(A[C])?1:-1}},_getObjName:function(A){return"grid_"+A},_getViewName:function(A){return A.replace(/^grid_/,"")}};scheduler.createGridView=function(D){var A=D.name||"grid";var C=scheduler.grid._getObjName(A);scheduler.config[A+"_start"]=D.from||(new Date(0));scheduler.config[A+"_end"]=D.to||(new Date(9999,1,1));scheduler[C]=D;scheduler[C].sort_field="start_date";scheduler[C].direction="asc";scheduler[C].columns=scheduler[C].fields;delete scheduler[C].fields;for(var B=0;B<scheduler[C].columns.length;B++){scheduler[C].columns[B].initialWidth=scheduler[C].columns[B].width}scheduler[C].select=D.select===undefined?true:D.select;if(scheduler.locale.labels[A+"_tab"]===undefined){scheduler.locale.labels[A+"_tab"]=scheduler[C].label||scheduler.locale.labels.grid_tab}scheduler[C]._selected_divs=[];scheduler.date[A+"_start"]=function(E){return E};scheduler.date["add_"+A]=function(F,G){var E=new Date(F);E.setMonth(E.getMonth()+G);return E};scheduler.templates[A+"_date"]=function(F,E){return scheduler.templates.day_date(F)+" - "+scheduler.templates.day_date(E)};scheduler.attachEvent("onTemplatesReady",function(){scheduler.templates[A+"_full_date"]=function(I,G,H){if(H._timed){return this.day_date(H.start_date,H.end_date,H)+" "+this.event_date(I)}else{return scheduler.templates.day_date(I)+" &ndash; "+scheduler.templates.day_date(G)}};scheduler.templates[A+"_single_date"]=function(G){return scheduler.templates.day_date(G)+" "+this.event_date(G)};scheduler.attachEvent("onDblClick",function(H,G){if(this._mode==A){scheduler._click.buttons.details(H);return false}return true});scheduler.attachEvent("onClick",function(H,G){if(this._mode==A&&scheduler[C].select){scheduler.grid.unselectEvent("",A);scheduler.grid.selectEvent(H,A,G);return false}return true});scheduler.templates[A+"_field"]=function(H,G){return G[H]};scheduler.attachEvent("onSchedulerResize",function(){if(this._mode==A){this[A+"_view"](true);return false}return true});var F=scheduler.render_data;scheduler.render_data=function(G){if(this._mode==A){scheduler.grid._fill_grid_tab(C)}else{return F.apply(this,arguments)}};var E=scheduler.render_view_data;scheduler.render_view_data=function(){if(this._mode==A){scheduler.grid._gridScrollTop=scheduler._els.dhx_cal_data[0].childNodes[0].scrollTop;scheduler._els.dhx_cal_data[0].childNodes[0].scrollTop=0;scheduler._els.dhx_cal_data[0].style.overflowY="auto"}else{scheduler._els.dhx_cal_data[0].style.overflowY="auto"}return E.apply(this,arguments)}});scheduler[A+"_view"]=function(E){if(E){scheduler._min_date=scheduler[C].paging?scheduler.date[A+"_start"](scheduler._date):scheduler.config[A+"_start"];scheduler._max_date=scheduler[C].paging?scheduler.date.add(scheduler._min_date,1,A):scheduler.config[A+"_end"];scheduler.grid.set_full_view(C);if(scheduler._min_date>new Date(0)&&scheduler._max_date<(new Date(9999,1,1))){scheduler._els.dhx_cal_date[0].innerHTML=scheduler.templates[A+"_date"](scheduler._min_date,scheduler._max_date)}else{scheduler._els.dhx_cal_date[0].innerHTML=""}scheduler.grid._fill_grid_tab(C);scheduler._gridView=C}else{scheduler.grid._sort_marker=null;delete scheduler._gridView;scheduler._rendered=[];scheduler[C]._selected_divs=[]}}};scheduler.dblclick_dhx_grid_area=function(){if(!this.config.readonly&&this.config.dblclick_create){this.addEventNow()}};if(scheduler._click.dhx_cal_header){scheduler._old_header_click=scheduler._click.dhx_cal_header}scheduler._click.dhx_cal_header=function(B){if(scheduler._gridView){var A=B||window.event;var C=scheduler.grid.get_sort_params(A,scheduler._gridView);scheduler.grid.draw_sort_marker(A.originalTarget||A.srcElement,C.dir);scheduler[scheduler._gridView].sort_rule=C.rule;scheduler[scheduler._gridView].sort_field=C.field;scheduler[scheduler._gridView].direction=C.dir;scheduler.clear_view();scheduler.grid._fill_grid_tab(scheduler._gridView)}else{if(scheduler._old_header_click){return scheduler._old_header_click.apply(this,arguments)}}};scheduler.grid.selectEvent=function(D,B,A){if(scheduler.callEvent("onBeforeRowSelect",[D,A])){var C=scheduler.grid._getObjName(B);scheduler.for_rendered(D,function(E){E.className+=" dhx_grid_event_selected";scheduler[C]._selected_divs.push(E)});scheduler._select_id=D}};scheduler.grid._unselectDiv=function(A){A.className=A.className.replace(/ dhx_grid_event_selected/,"")};scheduler.grid.unselectEvent=function(D,B){var C=scheduler.grid._getObjName(B);if(!C||!scheduler[C]._selected_divs){return }if(!D){for(var A=0;A<scheduler[C]._selected_divs.length;A++){scheduler.grid._unselectDiv(scheduler[C]._selected_divs[A])}scheduler[C]._selected_divs=[]}else{for(var A=0;A<scheduler[C]._selected_divs.length;A++){if(scheduler[C]._selected_divs[A].getAttribute("event_id")==D){scheduler.grid._unselectDiv(scheduler[C]._selected_divs[A]);scheduler[C]._selected_divs.slice(A,1);break}}}};scheduler.grid.get_sort_params=function(D,E){var C=D.originalTarget||D.srcElement;if(C.className=="dhx_grid_view_sort"){C=C.parentNode}if(!C.className||C.className.indexOf("dhx_grid_sort_asc")==-1){var H="asc"}else{var H="desc"}var A=0;for(var B=0;B<C.parentNode.childNodes.length;B++){if(C.parentNode.childNodes[B]==C){A=B;break}}var G=scheduler[E].columns[A].id;var F=scheduler[E].columns[A].sort;if(typeof F!="function"){F=scheduler.grid.sort_rules[F]||scheduler.grid.sort_rules.str}return{dir:H,field:G,rule:F}};scheduler.grid.draw_sort_marker=function(B,C){if(B.className=="dhx_grid_view_sort"){B=B.parentNode}if(scheduler.grid._sort_marker){scheduler.grid._sort_marker.className=scheduler.grid._sort_marker.className.replace(/( )?dhx_grid_sort_(asc|desc)/,"");scheduler.grid._sort_marker.removeChild(scheduler.grid._sort_marker.lastChild)}B.className+=" dhx_grid_sort_"+C;scheduler.grid._sort_marker=B;var A="<div class='dhx_grid_view_sort' style='left:"+(+B.style.width.replace("px","")-15+B.offsetLeft)+"px'>&nbsp;</div>";B.innerHTML+=A};scheduler.grid.sort_grid=function(D,C,B){if(D=="date"){D="start_date"}var A=scheduler.get_visible_events();if(C=="desc"){A.sort(function(F,E){return B(F,E,D)})}else{A.sort(function(F,E){return -B(F,E,D)})}return A};scheduler.grid.set_full_view=function(C){if(C){var A=scheduler.locale.labels;var B=scheduler.grid._print_grid_header(C);scheduler._els.dhx_cal_header[0].innerHTML=B;scheduler._table_view=true;scheduler.set_sizes()}};scheduler.grid._fill_grid_tab=function(F){var B=scheduler._date;var G=scheduler[F].sort_rule||scheduler.grid.sort_rules.str;var I=scheduler.grid.sort_grid(scheduler[F].sort_field,scheduler[F].direction,G);var C=scheduler[F].columns;var E="<div>";var A=-2;for(var D=0;D<C.length;D++){A+=C[D].width+5;if(D<C.length-1){E+="<div class='dhx_grid_v_border' style='left:"+(A)+"px'></div>"}}E+="</div>";E+="<div class='dhx_grid_area'>";for(var D=0;D<I.length;D++){E+=scheduler.grid._print_event_row(I[D],F)}E+="</div>";scheduler._els.dhx_cal_data[0].innerHTML=E;scheduler._els.dhx_cal_data[0].scrollTop=scheduler.grid._gridScrollTop||0;var H=scheduler._els.dhx_cal_data[0].lastChild.childNodes;scheduler._rendered=[];for(var D=0;D<H.length;D++){if(H[D].className.indexOf("dhx_grid_v_border")==-1){scheduler._rendered[D]=H[D]}}};scheduler.grid._print_event_row=function(I,G){var L=[];if(I.color){L.push("background-color:"+I.color)}if(I.textColor){L.push("color:"+I.textColor)}if(I._text_style){L.push(I._text_style)}if(scheduler[G]["rowHeight"]){L.push("height:"+scheduler[G]["rowHeight"]+"px")}var A="";if(L.length){A="style='"+L.join(";")+"'"}var C=scheduler[G].columns;var E=scheduler.templates.event_class(I.start_date,I.end_date,I);var F="<div class='dhx_body"+(E?" "+E:"")+"' event_id='"+I.id+"' "+A+">";var B=scheduler.grid._getViewName(G);for(var D=0;D<C.length;D++){var K;if(C[D].template){K=C[D].template(I.start_date,I.end_date,I)}else{if(C[D].id=="date"){K=scheduler.templates[B+"_full_date"](I.start_date,I.end_date,I)}else{if(C[D].id=="start_date"||C[D].id=="end_date"){K=scheduler.templates[B+"_single_date"](I[C[D].id])}else{K=scheduler.templates[B+"_field"](C[D].id,I)}}}var J="";if(C[D].align){J="text-align:"+C[D].align+";"}var H=(scheduler[G]["rowHeight"]&&C[D].valign);if(H){K="<table><td style='vertical-align:"+C[D].valign+";'>"+K+"</td></table>"}F+="<div style='width:"+(C[D].width)+"px;"+J+"'>"+K+"</div>"}F+="</div>";return F};scheduler.grid._print_grid_header=function(H){var I="<div class='dhx_grid_line'>";var F=scheduler[H].columns;var E=[];var L=F.length;var A=scheduler._obj.clientWidth-2*F.length-20;for(var C=0;C<F.length;C++){var B=F[C].initialWidth*1;if(!isNaN(B)&&F[C].initialWidth!=""&&F[C].initialWidth!=null&&typeof F[C].initialWidth!="boolean"){L--;A-=B;E[C]=B}else{E[C]=null}}var D=Math.floor(A/L);for(var G=0;G<F.length;G++){var K=!E[G]?D:E[G];F[G].width=K-4;var J="";if(F[G].align){J="text-align:"+F[G].align+";"}I+="<div style='width:"+(F[G].width)+"px;"+J+"'>"+(F[G].label===undefined?F[G].id:F[G].label)+"</div>"}I+="</div>";return I};