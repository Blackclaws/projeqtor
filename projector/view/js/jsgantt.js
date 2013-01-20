/*
=> Closing Sub 2 or Sub 2.2 or Act 2.2 : OKCopyright (c) 2009, Shlomy Gantz BlueBrick Inc. All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions are met:
*     * Redistributions of source code must retain the above copyright
*       notice, this list of conditions and the following disclaimer.
*     * Redistributions in binary form must reproduce the above copyright
*       notice, this list of conditions and the following disclaimer in the
*       documentation and/or other materials provided with the distribution.
*     * Neither the name of Shlomy Gantz or BlueBrick Inc. nor the
*       names of its contributors may be used to endorse or promote products
*       derived from this software without specific prior written permission.
*
* THIS SOFTWARE IS PROVIDED BY SHLOMY GANTZ/BLUEBRICK INC. ''AS IS'' AND ANY
* EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
* DISCLAIMED. IN NO EVENT SHALL SHLOMY GANTZ/BLUEBRICK INC. BE LIABLE FOR ANY
* DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
* (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
* LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
* ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
* SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

/**
 * JSGantt component is a UI control that displays gantt charts based by using
 * CSS and HTML
 * 
 * @module jsgantt
 * @title JSGantt
 */
var JSGantt; if (!JSGantt) JSGantt = {};
var vTimeout = 0;
var vBenchTime = new Date().getTime();
var arrayClosed=new Array();

JSGantt.TaskItem = function(pID, pName, pStart, pEnd, pColor, pLink, pMile, pRes, pComp, pGroup, 
                            pParent, pOpen, pDepend, pCaption, pClass, pScope, pRealEnd, pPlanStart,
                            pValidatedWork, pAssignedWork, pRealWork, pLeftWork, pPlannedWork) {
  var vID    = pID;
  var vName  = pName;
  var vStart = new Date();  
  var vEnd   = new Date();
  var vColor = pColor;
  var vLink  = pLink;
  var vMile  = pMile;
  var vRes   = pRes;
  var vComp  = pComp;
  var vGroup = pGroup;
  var vParent = pParent;
  var vOpen   = pOpen;
  var vDepend = pDepend;
  var vCaption = pCaption;
  var vDuration = '';
  var vLevel = 0;
  var vNumKid = 0;
  var vVisible  = 1;
  var x1, y1, x2, y2;
  var vClass=pClass;
  var vScope=pScope;
  var vRealEnd=new Date();
  var vPlanStart=new Date();
  var vValidatedWork=pValidatedWork;
  var vAssignedWork=pAssignedWork;
  var vRealWork=pRealWork;
  var vLeftWork=pLeftWork;
  var vPlannedWork=pPlannedWork;
  vStart = JSGantt.parseDateStr(pStart,g.getDateInputFormat());
  vEnd   = JSGantt.parseDateStr(pEnd,g.getDateInputFormat());
  vRealEnd = JSGantt.parseDateStr(pRealEnd,g.getDateInputFormat());
  vPlanStart = JSGantt.parseDateStr(pPlanStart,g.getDateInputFormat());
  this.getID       = function(){ return vID; };
  this.getName     = function(){ return vName; };
  this.getStart    = function(){ return vStart;};
  this.getEnd      = function(){ return vEnd;  };
  this.getRealEnd  = function(){ return vRealEnd;  };
  this.getPlanStart= function(){ return vPlanStart;  };
  this.getValidatedWork     = function(){ return vValidatedWork;  };
  this.getAssignedWork     = function(){ return vAssignedWork;  };
  this.getRealWork     = function(){ return vRealWork;  };
  this.getLeftWork     = function(){ return vLeftWork;  };
  this.getPlannedWork     = function(){ return vPlannedWork;  };
  this.getColor    = function(){ return vColor;};
  this.getLink     = function(){ return vLink; };
  this.getMile     = function(){ return vMile; };
  this.getDepend   = function(){ if(vDepend) return vDepend; else return null; };
  this.getCaption  = function(){ if(vCaption) return vCaption; else return ''; };
  this.getResource = function(){ if(vRes) return vRes; else return '&nbsp';  };
  this.getCompVal  = function(){ if(vComp) return vComp; else return 0; };
  this.getCompStr  = function(){ if(vComp) return vComp+'%'; else return '0%'; };
  this.getDuration = function(vFormat){ 
    if (vMile) { 
      vDuration = '-';
    } else if (vFormat=='hour') {
      tmpPer =  Math.ceil((this.getEnd() - this.getStart()) /  ( 60 * 60 * 1000) );
      vDuration = tmpPer + ' ' + i18n('shortHour');
    } else if (vFormat=='minute') {
      tmpPer =  Math.ceil((this.getEnd() - this.getStart()) /  ( 60 * 1000) );
      vDuration = tmpPer + ' ' + i18n('shortMinute');
    } else {
      if (this.getStart()==null || this.getEnd()==null) {
    	if (this.getStart()==null && this.getRealEnd()==null) {
    	  vDuration = '-';
    	} else {
    	  tmpPer =  workDayDiffDates(this.getStart(), this.getRealEnd());
          vDuration = tmpPer + ' ' + i18n('shortDay');
    	}
      } else {
        tmpPer =  workDayDiffDates(this.getStart(), this.getEnd());
        vDuration = tmpPer + ' ' + i18n('shortDay');
//console.log(this.getID()+" = "+this.getEnd()+" - "+this.getStart()+" = "+vDuration);    	  
      }
    }
    return( vDuration );
  };
  this.getParent   = function(){ return vParent; };
  this.getGroup    = function(){ return vGroup; };
  this.getOpen     = function(){ return vOpen; };
  this.getLevel    = function(){ return vLevel; };
  this.getNumKids  = function(){ return vNumKid; };
  this.getStartX   = function(){ return x1; };
  this.getStartY   = function(){ return y1; };
  this.getEndX     = function(){ return x2; };
  this.getEndY     = function(){ return y2; };
  this.getVisible  = function(){ return vVisible; };
  this.getScope    = function(){ return vScope; };
  this.getClass  = function(){ return vClass; };
  this.setDepend   = function(pDepend){ vDepend = pDepend;};
  this.setStart    = function(pStart){ vStart = pStart;};
  this.setEnd      = function(pEnd)  { vEnd   = pEnd;  };
  this.setPlanStart= function(pPlanStart){ vPlanStart = pPlanStart;};
  this.setRealEnd  = function(pRealEnd)  { vRealEnd   = pRealEnd;  };
  this.setWork     = function(pWork)  { vWork   = pWork;  };
  this.setLevel    = function(pLevel){ vLevel = pLevel;};
  this.setNumKid   = function(pNumKid){ vNumKid = pNumKid;};
  this.setCompVal  = function(pCompVal){ vComp = pCompVal;};
  this.setStartX   = function(pX) {x1 = pX; };
  this.setStartY   = function(pY) {y1 = pY; };
  this.setEndX     = function(pX) {x2 = pX; };
  this.setEndY     = function(pY) {y2 = pY; };
  this.setOpen     = function(pOpen) {vOpen = pOpen; };
  this.setVisible  = function(pVisible) {vVisible = pVisible; };
  this.setClass  = function(pClass) {vClass = pClass; };
  this.setScope  = function(pScope) {vScope = pScope; };
};  
  
/**
 * Creates the gant chart.
 */
JSGantt.GanttChart =  function(pGanttVar, pDiv, pFormat) {
  var vGanttVar = pGanttVar;
  var vDiv      = pDiv;
  var vFormat   = pFormat;
  var vShowRes  = 1;
  var vShowDur  = 1;
  var vShowComp = 1;
  var vShowStartDate = 1;
  var vShowEndDate = 1;
  var vShowValidatedWork = 0;
  var vShowAssignedWork = 0;
  var vShowRealWork = 0;
  var vShowLeftWork = 0;
  var vShowPlannedWork = 0;
  var vSortArray=new Array();
  var vSplitted = false;
  var vDateInputFormat = "yyyy-mm-dd";
  var vDateDisplayFormat = "yyyy-mm-dd";
  var vNumUnits  = 0;
  var vCaptionType;
  var vDepId = 1;
  var vTaskList     = new Array();  
  var vFormatArr  = new Array("day","week","month","quarter");
  var vQuarterArr   = new Array(1,1,1,2,2,2,3,3,3,4,4,4);
  var vMonthDaysArr = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
  var vMonthArr     = new Array(JSGantt.i18n("January"),JSGantt.i18n("February"),JSGantt.i18n("March"),
                                JSGantt.i18n("April"), JSGantt.i18n("May"),JSGantt.i18n("June"),
                                JSGantt.i18n("July"),  JSGantt.i18n("August"),  JSGantt.i18n("September"),
                                JSGantt.i18n("October"),JSGantt.i18n("November"),JSGantt.i18n("December"));
  var vGanttWidth=1000;
  var vStartDateView=new Date();
  var vEndDateView=new Date();
  this.setFormatArr = function() {
    vFormatArr = new Array();
    for(var i = 0; i < arguments.length; i++) {vFormatArr[i] = arguments[i];}
    if(vFormatArr.length>4){vFormatArr.length=4;}
  };
  this.setShowRes  = function(pShow) { vShowRes  = pShow; };
  this.setShowDur  = function(pShow) { vShowDur  = pShow; };
  this.setShowComp = function(pShow) { vShowComp = pShow; };
  this.setShowValidatedWork = function(pValidatedWork) { vShowValidatedWork = pValidatedWork; };
  this.setShowAssignedWork = function(pAssignedWork) { vShowAssignedWork = pAssignedWork; };
  this.setShowRealWork = function(pRealWork) { vShowRealWork = pRealWork; };
  this.setShowLeftWork = function(pLeftWork) { vShowLeftWork = pLeftWork; };
  this.setShowPlannedWork = function(pPlannedWork) { vShowPlannedWork = pPlannedWork; };
  this.setSortArray = function(pSortArray) { vSortArray = pSortArray; };
  this.setSplitted = function(pSplitted) { vSplitted = pSplitted; };
  this.setShowStartDate = function(pShow) { vShowStartDate = pShow; };
  this.setShowEndDate = function(pShow) { vShowEndDate = pShow; };
  this.setDateInputFormat = function(pShow) { vDateInputFormat = pShow; };
  this.setDateDisplayFormat = function(pShow) { vDateDisplayFormat = pShow; };
  this.setCaptionType = function(pType) { vCaptionType = pType; };

  this.setFormat = function(pFormat){ 
    vFormat = pFormat; 
    this.clearDependencies();
    this.ClearGraph();
    this.Draw(); 
  };
  this.setWidth = function (pWidth) {vGanttWidth=pWidth;};
  this.setStartDateView = function (pStartDateView) { vStartDateView=pStartDateView; };
  this.setEndDateView = function (pEndDateView) { vEndDateView=pEndDateView; };
  this.resetStartDateView = function () {
    if (dijit.byId('startDatePlanView')) {
      vStartDateView=dijit.byId('startDatePlanView').get('value');
    }
  };
  this.resetEndDateView = function () {
	    if (dijit.byId('endDatePlanView')) {
	      vEndDateView=dijit.byId('endDatePlanView').get('value');
	    }
	  };
  this.getShowRes  = function(){ return vShowRes; };
  this.getShowDur  = function(){ return vShowDur; };
  this.getShowComp = function(){ return vShowComp; };
  this.getShowValidatedWork = function(){ return vShowValidatedWork; };
  this.getShowAssignedWork = function(){ return vShowAssignedWork; };
  this.getShowRealWork = function(){ return vShowRealWork; };
  this.getShowLeftWork = function(){ return vShowLeftWork; };
  this.getShowPlannedWork = function(){ return vShowPlannedWork; };
  this.getSplitted = function(){ return vSplitted; };
  this.getShowStartDate = function(){ return vShowStartDate; };
  this.getShowEndDate = function(){ return vShowEndDate; };
  this.getSortArray = function(){ return vSortArray; };
  this.getDateInputFormat = function() { return vDateInputFormat; };
  this.getDateDisplayFormat = function() { return vDateDisplayFormat; };
  this.getCaptionType = function() { return vCaptionType; };
  this.getWidth = function() { return vGanttWidth; };
  this.getStartDateView = function() { return vStartDateView; };
  this.getEndDateView = function() { return vEndDateView; };
  this.getInitialStartDateView = function() { return vInitialStartDateView; };
  this.getFormat = function(){ return vFormat; };
  this.CalcTaskXY = function () { 
    var vList = this.getList();
    var vTaskDiv;
    var vParDiv;
    var vLeft, vTop, vHeight, vWidth;
    for(i = 0; i < vList.length; i++) {
      vID = vList[i].getID();
      vTaskDiv = JSGantt.findObj("taskbar_"+vID);
      vBarDiv  = JSGantt.findObj("bardiv_"+vID);
      vParDiv  = JSGantt.findObj("childgrid_"+vID);
      if(vBarDiv) {
        vList[i].setStartX( vBarDiv.offsetLeft );
        vList[i].setEndX( vBarDiv.offsetLeft + vBarDiv.offsetWidth );
        if (vList[i].getMile()) {
          vList[i].setEndY( vParDiv.offsetTop+vBarDiv.offsetTop+12 );
          vList[i].setStartY( vParDiv.offsetTop+vBarDiv.offsetTop+12 );
        } else {
          vList[i].setEndY( vParDiv.offsetTop+vBarDiv.offsetTop+6 );
          vList[i].setStartY( vParDiv.offsetTop+vBarDiv.offsetTop+6 );
        }
      };
    };
  };
  /* Does not work : cannot remove node, always referenced */
   this.ClearGraph = function () {
	  var vList = this.getList();
	  var vBarDiv;
	  for(i = 0; i < vList.length; i++) {
		  vID = vList[i].getID();
		  vBarDiv  = JSGantt.findObj("bardiv_"+vID);
		  if(vBarDiv) {
			  //vBarDiv.parentNode.removeChild(vBarDiv); 
			  //dojo.destroy(vBarDiv);
			  dojo.query("#bardiv_"+vID).orphan();
		  }
	  }
  };
  this.AddTaskItem = function(value) {
    vTaskList.push(value);
  };
  this.getList   = function() { return vTaskList; };
  this.clearDependencies = function() {
    //var parent = JSGantt.findObj('rightside');
	  var parent = JSGantt.findObj('rightGanttChartDIV');
	var depLine;
    var vMaxId = vDepId;
    for ( i=1; i<vMaxId; i++ ) {
      depLine = JSGantt.findObj("line"+i);
      if (depLine) { parent.removeChild(depLine); }
    };
    vDepId = 1;
  };
  this.sLine = function(x1,y1,x2,y2,color) {
    vLeft = Math.min(x1,x2);
    vTop  = Math.min(y1,y2);
    vWid  = Math.abs(x2-x1) + 1;
    vHgt  = Math.abs(y2-y1) + 1;
    vDoc = JSGantt.findObj('rightGanttChartDIV');
    //vDoc = JSGantt.findObj('rightside');
    var oDiv = document.createElement('div');
    oDiv.id = "line"+vDepId++;
    oDiv.style.position = "absolute";
    oDiv.style.margin = "0px";
    oDiv.style.padding = "0px";
    oDiv.style.overflow = "hidden";
    oDiv.style.border = "0px";
    oDiv.style.zIndex = 0;
    if (!color) color="#000000";
    color="#000000";
    oDiv.style.backgroundColor = color;
    oDiv.style.left = vLeft + "px";
    oDiv.style.top = vTop + "px";
    oDiv.style.width = vWid + "px";
    oDiv.style.height = vHgt + "px";
    oDiv.style.visibility = "visible";
    vDoc.appendChild(oDiv);
  };
  this.dLine = function(x1,y1,x2,y2,color) {
    var dx = x2 - x1;
    var dy = y2 - y1;
    var x = x1;
    var y = y1;
    var n = Math.max(Math.abs(dx),Math.abs(dy));
    dx = dx / n;
    dy = dy / n;
    for ( i = 0; i <= n; i++ ) {
      vx = Math.round(x); 
      vy = Math.round(y);
      if (!color) color="#000000";
      this.sLine(vx,vy,vx,vy,color);
      x += dx;
      y += dy;
    };
  };
  this.drawDependency =function(x1,y1,x2,y2,color) {
    if (x1 <= x2+4) {
      if (y1 <= y2) {
        this.sLine(x1,y1,x2+4,y1,color);
        this.sLine(x2+4,y1,x2+4,y2-6,color);
        this.sLine(x2+1, y2-9, x2+7, y2-9,color);
        this.sLine(x2+2, y2-8, x2+6, y2-8,color);
        this.sLine(x2+3, y2-7, x2+5, y2-7,color);
      } else {
        this.sLine(x1,y1,x2+4,y1,color);
        this.sLine(x2+4,y1,x2+4,y2+6,color);
        this.sLine(x2+1, y2+9, x2+7, y2+9,color);
        this.sLine(x2+2, y2+8, x2+6, y2+8,color);
        this.sLine(x2+3, y2+7, x2+5, y2+7,color);
      }
    } else {
      if (y1 <= y2) {
        this.sLine(x1,y1,x1+4,y1,color);
        this.sLine(x1+4,y1,x1+4,y2-8,color);
        this.sLine(x1+4,y2-8,x2-8,y2-8,color);
        this.sLine(x2-8,y2-8,x2-8,y2,color);
        this.sLine(x2-8,y2,x2,y2,color);
        this.sLine(x2-3,y2+3,x2-3,y2-3,color);
        this.sLine(x2-2,y2+2,x2-2,y2-2,color);
        this.sLine(x2-1,y2+1,x2-1,y2-1,color);
      } else {
    	this.sLine(x1,y1,x1+4,y1,color);
        this.sLine(x1+4,y1,x1+4,y2+8,color);
        this.sLine(x1+4,y2+8,x2-8,y2+8,color);
        this.sLine(x2-8,y2+8,x2-8,y2,color);
        this.sLine(x2-8,y2,x2,y2,color);
        this.sLine(x2-3,y2+3,x2-3,y2-3,color);
        this.sLine(x2-2,y2+2,x2-2,y2-2,color);
        this.sLine(x2-1,y2+1,x2-1,y2-1,color);
      }
    }
  };
  this.DrawDependencies = function () {
    this.CalcTaskXY();
    this.clearDependencies();
    var vList = this.getList();
    for(var i = 0; i < vList.length; i++) {
      vDepend = vList[i].getDepend();
      if(vDepend) {
        var vDependStr = vDepend + '';
        var vDepList = vDependStr.split(',');
        var n = vDepList.length;
        for(var k=0;k<n;k++) {
          var vTask = this.getArrayLocationByID(vDepList[k]);
          if(vTask!=null && vList[vTask].getVisible()==1 && vList[i].getVisible()==1) {
            this.drawDependency(vList[vTask].getEndX(),vList[vTask].getEndY(),vList[i].getStartX()-1,
                            vList[i].getStartY(),"#"+vList[vTask].getColor());
          }
        }
      }
    }
  };
  this.getArrayLocationByID = function(pId)  {
    var vList = this.getList();
    for(var i = 0; i < vList.length; i++) {
      if(vList[i].getID()==pId) {
        return i;
      }
    }
  };
  this.Draw = function(){
	top.showWait();
    var vMaxDate = new Date();
    var vMinDate = new Date();
    var vDefaultMinDate = new Date();
    var vTmpDate = new Date();
    var vNxtDate = new Date();
    var vCurrDate = new Date();
    var vTaskLeft = 0;
    var vTaskRight = 0;
    var vNumCols = 0;
    var vID = 0;
    var vMainTable = "";
    var vLeftTable = "";
    var vRightTable = "";
    var vDateRowStr = "";
    var vItemRowStr = "";
    var vColWidth = 0;
    var vColUnit = 0;
    var vChartWidth = 0;
    var vNumDays = 0;
    var vNumUnits = 1;
    var vDayWidth = 0;
    var vStr = "";
    var vRowType="";
    var vNameWidth = 300;  
    var vStatusWidth = 70;
    var vResourceWidth = 90;
    var vWorkWidth = 70;
    var vDateWidth = 80;
    var vDurationWidth = 60;
    var vProgressWidth = 50;
    var vWidth=this.getWidth();
    var vLeftWidth = 16 
      +   vNameWidth 
      + ( (1+vResourceWidth) * this.getShowRes() )
      + ( (1+vDurationWidth) * this.getShowDur() )
      + ( (1+vProgressWidth) * this.getShowComp() )
      + ( (1+vDateWidth) * this.getShowStartDate() )
      + ( (1+vDateWidth) * this.getShowEndDate() )
      + ( (1+vWorkWidth) * this.getShowLeftWork() )
      + ( (1+vWorkWidth) * this.getShowAssignedWork() )
      + ( (1+vWorkWidth) * this.getShowPlannedWork() )
      + ( (1+vWorkWidth) * this.getShowRealWork() )
      + ( (1+vWorkWidth) * this.getShowValidatedWork() );
    var vRightWidth = vWidth - vLeftWidth - 18;
    var ffSpecificHeight=(dojo.isFF<16)?' class="ganttHeight"':'';
    var vLeftTable="";
    var vRightTable="";
    var vTopRightTable="";
    if(vTaskList.length > 0) {
      JSGantt.processRows(vTaskList, 0, -1, 1, 1);
      vMinDate = JSGantt.getMinDate(vTaskList, vFormat,g.getStartDateView());
      vDefaultMinDate = JSGantt.getMinDate(vTaskList, vFormat);
      vMaxDate = JSGantt.getMaxDate(vTaskList, vFormat, g.getEndDateView());
      vDefaultMaxDate = JSGantt.getMaxDate(vTaskList, vFormat);
      if(vFormat == 'day') {
        vColWidth = 18;
        vColUnit = 1;
      } else if(vFormat == 'week') {
        vColWidth = 50;
        vColUnit = 7;
      } else if(vFormat == 'month') {
        vColWidth = 90;
        vColUnit = 30.5;
      } else if(vFormat == 'quarter') {
        vColWidth = 100;
        vColUnit = 90;
      }
      vMinDate.setHours(0, 0, 0, 0);
      vMaxDate.setHours(23, 59, 59, 0);
      vNumDays = (Date.parse(vMaxDate) - Date.parse(vMinDate)) / ( 24 * 60 * 60 * 1000);
      vNumDays = Math.ceil(vNumDays);
      vNumUnits = vNumDays / vColUnit;
      vNumUnits=Math.round(vNumUnits);
      vChartWidth = vNumUnits * (vColWidth + 1);
      vDayWidth = (vColWidth / vColUnit) + (1/vColUnit);
      /*if(vShowRes !=1) vNameWidth+=vResourceWidth;
      if(vShowDur !=1) vNameWidth+=vDurationWidth;
      if(vShowComp!=1) vNameWidth+=vProgressWidth;
      if(vShowStartDate!=1) vNameWidth+=vDateWidth;
      if(vShowEndDate!=1) vNameWidth+=vDateWidth;  
      if(vShowLeftWork!=1) vNameWidth+=vWorkWidth;
      if(vShowPlannedWork!=1) vNameWidth+=vWorkWidth;
      if(vShowRealWork!=1) vNameWidth+=vWorkWidth;
      if(vShowValidatedWork!=1) vNameWidth+=vWorkWidth;*/
// LEFT ===========================================================
      vLeftTable = '<DIV class="scrollLeftTop" id="leftsideTop" style="width:' + vLeftWidth + 'px;">' 
        +'<TABLE jsId="topSourceTable" id="topSourceTable" class="ganttTable"><TBODY>'
        +'<TR class="ganttHeight">'
        +'<TD class="ganttLeftTopLine" style="width:16px;"></TD>'
        +'<TD class="ganttLeftTopLine" style="width: ' + vNameWidth + 'px;"><NOBR>';
      vLeftTable+=JSGantt.drawFormat(vFormatArr, vFormat, vGanttVar,'top');
      vLeftTable+= '</NOBR></TD>'; 
      sortArray=this.getSortArray();
      for (iSort=0;iSort<sortArray.length;iSort++) {
	      if(vShowValidatedWork ==1 && sortArray[iSort]=='ValidatedWork') { 
	        vLeftTable += '<TD class="ganttLeftTopLine" style="width: ' + vWorkWidth + 'px;"></TD>' ;
	      }
	      if(vShowAssignedWork ==1 && sortArray[iSort]=='AssignedWork') { 
	          vLeftTable += '<TD class="ganttLeftTopLine" style="width: ' + vWorkWidth + 'px;"></TD>' ;
	      }
	      if(vShowRealWork ==1 && sortArray[iSort]=='RealWork') { 
	        vLeftTable += '<TD class="ganttLeftTopLine" style="width: ' + vWorkWidth + 'px;"></TD>' ;
	      }
	      if(vShowLeftWork ==1 && sortArray[iSort]=='LeftWork') { 
	        vLeftTable += '<TD class="ganttLeftTopLine" style="width: ' + vWorkWidth + 'px;"></TD>' ;
	      }
	      if(vShowPlannedWork ==1 && sortArray[iSort]=='PlannedWork') { 
	        vLeftTable += '<TD class="ganttLeftTopLine" style="width: ' + vWorkWidth + 'px;"></TD>' ;
	      }        
	      if(vShowDur ==1 && sortArray[iSort]=='Duration') { 
	        vLeftTable += '<TD class="ganttLeftTopLine" style="width: ' + vDurationWidth + 'px;"></TD>' ;
	      }
	      if(vShowComp==1 && sortArray[iSort]=='Progress') {
	        vLeftTable += '<TD class="ganttLeftTopLine" style="width: ' + vProgressWidth + 'px;"></TD>' ;
	      }
	      if(vShowStartDate==1 && sortArray[iSort]=='StartDate') {
	        vLeftTable += '<TD class="ganttLeftTopLine" style="width: ' + vDateWidth + 'px;"></TD>' ;
	      }
	      if(vShowEndDate==1 && sortArray[iSort]=='EndDate') {
	        vLeftTable += '<TD class="ganttLeftTopLine" style="width: ' + vDateWidth + 'px;"></TD>' ;
	      }
	      if(vShowRes ==1 && sortArray[iSort]=='Resource') {
	        vLeftTable += '<TD class="ganttLeftTopLine" style="width: ' + vResourceWidth + 'px;"></TD>' ;
	      }
      }
      vLeftTable += '</TR><TR class="ganttHeight">'
        +'<TD class="ganttLeftTitle" style="width:16px;"></TD>'
        +'<TD class="ganttLeftTitle ganttAlignLeft ganntNoLeftBorder" style="width: ' + vNameWidth + 'px;">'
        +JSGantt.i18n('colTask') +'</TD>' ;     
      for (iSort=0;iSort<sortArray.length;iSort++) {
	      if(vShowValidatedWork ==1 && sortArray[iSort]=='ValidatedWork') {
	        vLeftTable += '<TD class="ganttLeftTitle" style="width: ' + vWorkWidth + 'px;" nowrap>' 
	          + JSGantt.i18n('colValidated') + '</TD>' ;
	      }
	      if(vShowAssignedWork ==1 && sortArray[iSort]=='AssignedWork') {
	        vLeftTable += '<TD class="ganttLeftTitle" style="width: ' + vWorkWidth + 'px;" nowrap>' 
	          + JSGantt.i18n('colAssigned') + '</TD>' ;
	      }
	      if(vShowRealWork ==1 && sortArray[iSort]=='RealWork') {
	        vLeftTable += '<TD class="ganttLeftTitle" style="width: ' + vWorkWidth + 'px;" nowrap>' 
	          + JSGantt.i18n('colReal') + '</TD>' ;
	      }
	      if(vShowLeftWork ==1 && sortArray[iSort]=='LeftWork') {
	        vLeftTable += '<TD class="ganttLeftTitle" style="width: ' + vWorkWidth + 'px;" nowrap>' 
	          + JSGantt.i18n('colLeft') + '</TD>' ;
	      }
	      if(vShowPlannedWork ==1 && sortArray[iSort]=='PlannedWork') {
	        vLeftTable += '<TD class="ganttLeftTitle" style="width: ' + vWorkWidth + 'px;" nowrap>' 
	          + JSGantt.i18n('colPlanned') + '</TD>' ;
	      }
	      if(vShowDur ==1 && sortArray[iSort]=='Duration') {
	        vLeftTable += '<TD class="ganttLeftTitle" style="width: ' + vDurationWidth + 'px;" nowrap>' 
	          + JSGantt.i18n('colDuration') + '</TD>' ;
	      }
	      if(vShowComp==1 && sortArray[iSort]=='Progress') {
	        vLeftTable += '<TD class="ganttLeftTitle" style="width: ' + vProgressWidth + 'px;" nowrap>' 
	          + JSGantt.i18n('colPct') + '</TD>' ;
	      }
	      if(vShowStartDate==1 && sortArray[iSort]=='StartDate') {
	        vLeftTable += '<TD class="ganttLeftTitle" style="width: ' + vDateWidth + 'px;" nowrap>' 
	          + JSGantt.i18n('colStart') + '</TD>' ;
	      }
	      if(vShowEndDate==1 && sortArray[iSort]=='EndDate') {
	        vLeftTable += '<TD class="ganttLeftTitle" style="width: ' + vDateWidth + 'px;" nowrap>' 
	          + JSGantt.i18n('colEnd') + '</TD>' ;
	      }
	      if(vShowRes ==1 && sortArray[iSort]=='Resource') {
	        vLeftTable += '<TD class="ganttLeftTitle" style="width: ' + vResourceWidth + 'px;" nowrap>' 
	          + JSGantt.i18n('colResource') + '</TD>' ;
	      }
      }
      vLeftTable += '</TR>';
      vLeftTable += '</TBODY></TABLE></DIV>'
        +'<DIV class="scrollLeft" id="leftside" style="z-index:-1;position:relative;width:' + vLeftWidth + 'px;">'
        + ( (dojo.ifFF)?'<div style="height:1px"></div>':'')
        +'<TABLE dojoType="dojo.dnd.Source" withHandles="false" jsId="dndSourceTable" id="dndSourceTable" '
        +'class="ganttTable"  ><TBODY>';
      for(i = 0; i < vTaskList.length; i++) {
        if( vTaskList[i].getGroup()) {
          vRowType = "group";
        } else if( vTaskList[i].getMile()){
          vRowType  = "mile";
        } else {
          vRowType  = "row";
        }
        vID = vTaskList[i].getID();
        var invisibleDisplay=(vTaskList[i].getVisible() == 0)?'style="display:none"':'';
        vLeftTable += '<TR id=child_' + vID + ' class="dojoDndItem ganttTask' + vRowType + '" ' 
          + invisibleDisplay
          + ' xonMouseover=JSGantt.ganttMouseOver(' + vID + ',"left","' + vRowType + '")'
          + ' xonMouseout=JSGantt.ganttMouseOut(' + vID + ',"left","' + vRowType + '")>' ;
        vLeftTable += '  <TD class="ganttName" style="width:16px">'
          +'<img style="width:16px" src="css/images/icon' 
          + vTaskList[i].getClass() + '16.png" /></TD>'
          +'<TD class="ganttName ganttAlignLeft" style="width: ' + vNameWidth + 'px;" nowrap>';
        vLeftTable += '<div style="width: ' + vNameWidth + 'px;">';
        var levl=vTaskList[i].getLevel();
        var levlWidth = (levl-1) * 16;
        vLeftTable +='<table><tr><td>';
        vLeftTable += '<div style="width:' + levlWidth + 'px;">&nbsp;</div>';
        vLeftTable +='</td><td>';
        if( vTaskList[i].getGroup()) {
          if( vTaskList[i].getOpen() == 1) {
            vLeftTable += '<div id="group_' + vID + '" class="ganttExpandOpened"' 
              + 'style="width:16px; height:13px;"'
              +' onclick="JSGantt.folder(' + vID + ','+vGanttVar+');'+vGanttVar+'.DrawDependencies();">'           
              +'</div>' ;
          } else {
            vLeftTable += '<div id="group_' + vID + '" class="ganttExpandClosed"' 
              + 'style="width:16px; height:13px;"'
              +' onclick="JSGantt.folder(' + vID + ','+vGanttVar+');'+vGanttVar+'.DrawDependencies();">' 
              +'&nbsp;&nbsp;&nbsp;&nbsp;</div>' ;
          } 
        } else {
          if( vTaskList[i].getMile() ) {
        	  vLeftTable += '<div style="width:16px; height:13px;" class="ganttNoExpandMile"></div>';	
          } else {
            vLeftTable += '<div style="width:16px; height:13px;" class="ganttNoExpand"></div>';
          }
        }
        vLeftTable +='</td><td>';
        var nameLeftWidth= vNameWidth - 16 - levlWidth - 18 ;
        vLeftTable += '<div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; '
          +'width:'+ nameLeftWidth +'px;" onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");' 
          +' class="namePart' + vRowType + '"><NOBR>' + vTaskList[i].getName() + '</NOBR></div>' ;
        vLeftTable +='</td></tr></table></div>';
        vLeftTable +='</TD>';
        for (iSort=0;iSort<sortArray.length;iSort++) {
          if(vShowValidatedWork ==1 && sortArray[iSort]=='ValidatedWork') { 
            vLeftTable += '<TD class="ganttDetail" style="width: ' + vWorkWidth + 'px;">'
              +'<NOBR><span onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");' 
              +' class="hideLeftPart' + vRowType + '">' + vTaskList[i].getValidatedWork() 
              +'</span></NOBR></TD>' ;
          }
          if(vShowAssignedWork ==1 && sortArray[iSort]=='AssignedWork') { 
            vLeftTable += '<TD class="ganttDetail" style="width: ' + vWorkWidth + 'px;">'
              +'<NOBR><span onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");' 
              +' class="hideLeftPart' + vRowType + '">' + vTaskList[i].getAssignedWork() 
              +'</span></NOBR></TD>' ;
          }
          if(vShowRealWork ==1 && sortArray[iSort]=='RealWork') { 
            vLeftTable += '<TD class="ganttDetail" style="width: ' + vWorkWidth + 'px;">'
              +'<NOBR><span onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");' 
              +' class="hideLeftPart' + vRowType + '">' + vTaskList[i].getRealWork() 
              +'</span></NOBR></TD>' ;
          }
          if(vShowLeftWork ==1 && sortArray[iSort]=='LeftWork') { 
            vLeftTable += '<TD class="ganttDetail" style="width: ' + vWorkWidth + 'px;">'
              +'<NOBR><span onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");' 
              +' class="hideLeftPart' + vRowType + '">' + vTaskList[i].getLeftWork() 
              +'</span></NOBR></TD>' ;
          }
          if(vShowPlannedWork ==1 && sortArray[iSort]=='PlannedWork') { 
            vLeftTable += '<TD class="ganttDetail" style="width: ' + vWorkWidth + 'px;">'
              +'<NOBR><span onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");' 
              +' class="hideLeftPart' + vRowType + '">' + vTaskList[i].getPlannedWork() 
              +'</span></NOBR></TD>' ;
          }
          if(vShowDur ==1 && sortArray[iSort]=='Duration') { 
          vLeftTable += '<TD class="ganttDetail" style="width: ' + vDurationWidth + 'px;">'
            +'<NOBR><span onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");' 
            +' class="hideLeftPart' + vRowType + '">' + vTaskList[i].getDuration(vFormat) 
            +'</span></NOBR></TD>' ;
          }
          if(vShowComp==1 && sortArray[iSort]=='Progress') { 
          vLeftTable += '<TD class="ganttDetail" style="width: ' + vProgressWidth + 'px;">'
            +'<NOBR><span onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");'
            +' class="hideLeftPart' + vRowType + '">' + vTaskList[i].getCompStr()  
            +'</span></NOBR></TD>' ;
          }
          if(vShowStartDate==1 && sortArray[iSort]=='StartDate') {
          vLeftTable += '<TD class="ganttDetail" style="width: ' + vDateWidth + 'px;">'
            +'<NOBR><span onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");'
            +' class="hideLeftPart' + vRowType + '">' 
            + JSGantt.formatDateStr( vTaskList[i].getStart(), vDateDisplayFormat) 
            + '</span></NOBR></TD>' ;
          }
          if(vShowEndDate==1 && sortArray[iSort]=='EndDate') {
          vDispEnd=(vTaskList[i].getEnd())?vTaskList[i].getEnd():vTaskList[i].getRealEnd();
          vLeftTable += '  <TD class="ganttDetail" style="width: ' + vDateWidth + 'px;">'
            +'<NOBR><span onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");'
            +' class="hideLeftPart' + vRowType + '">' 
            + JSGantt.formatDateStr( vDispEnd, vDateDisplayFormat) 
            + '</span></NOBR></TD>' ;
          }
          if(vShowRes==1 && sortArray[iSort]=='Resource') {
            vLeftTable += '<TD class="ganttDetail" style="text-align:left;">' 
              +'<NOBR><span class="namePart' + vRowType + '" style="width: ' + vResourceWidth + 'px;">' 
              + vTaskList[i].getResource() + '</span></NOBR></TD>' ;
          }
        }
        vLeftTable += '</TR>';
      }
      vLeftTable += '<TR><TD style="width:16px;"></TD>';
      vLeftTable += '<TD colspan="' + sortArray.length +'"><NOBR>';
      vLeftTable += '</NOBR></TD></TR></TBODY></TABLE></DIV>';
// RIGHT ======================================================================
      vTopRightTable = '<DIV id="rightside" class="scrollRightTop" '
    	+' style="width: ' + vChartWidth + 'px; position:absolute; left:-1px;">';
      // if (dojo.isFF) {vTopRightTable += '<DIV
      // '+((dojo.isFF)?'style="height:39px':'')+'">';}
      vTopRightTable += '<TABLE style="width: ' + vChartWidth + 'px;">'
        + '<TBODY><TR class="ganttRightTitle">';
      vTmpDate.setFullYear(vMinDate.getFullYear(), vMinDate.getMonth(), vMinDate.getDate());
      vTmpDate.setHours(0);
      vTmpDate.setMinutes(0);
      while(Date.parse(vTmpDate) <= Date.parse(vMaxDate)) {  
        vStr = vTmpDate.getFullYear() + '';
        if (vFormat == 'day') {
          vTopRightTable += '<td class="ganttRightTitle" colspan="7">' 
            +JSGantt.formatDateStr(vTmpDate,"week-long",vMonthArr) + '</td>';
          vTmpDate.setDate(vTmpDate.getDate()+7);
        } else if (vFormat == 'week') {
          vTopRightTable += '<td class="ganttRightTitle">' 
            +JSGantt.formatDateStr(vTmpDate,"week-short",vMonthArr); + '</td>';
          vTmpDate.setDate(vTmpDate.getDate()+7);
        } else if (vFormat == 'month') {
          vTopRightTable += '<td class="ganttRightTitle" width='+vColWidth+'px>'+ vStr + '</td>';
          vTmpDate.setDate(vTmpDate.getDate() + 1);
          while(vTmpDate.getDate() > 1) {
            vTmpDate.setDate(vTmpDate.getDate() + 1);
          }
        } else if (vFormat == 'quarter') {
          vTopRightTable += '<td class="ganttRightTitle" width='+vColWidth+'px>'+ vStr + '</td>';
          vTmpDate.setDate(vTmpDate.getDate() + 81);
          while(vTmpDate.getDate() > 1) {
            vTmpDate.setDate(vTmpDate.getDate() + 1);
          }
        }
      }
      vTopRightTable += '</TR><TR>';
      vTmpDate.setFullYear(vMinDate.getFullYear(), vMinDate.getMonth(), vMinDate.getDate());
      vNxtDate.setFullYear(vMinDate.getFullYear(), vMinDate.getMonth(), vMinDate.getDate());
      vNumCols = 0;
      var vWeekendColor="dfdfdf";
      var vCurrentdayColor="ffffaa";
      while(Date.parse(vTmpDate) <= Date.parse(vMaxDate)) {  
        if(vFormat == 'day' ) {
          if(isOffDay(vTmpDate)) {
            vDateRowStr  += '<td class="ganttRightSubTitle" style="background-color:#' + vWeekendColor + '; " >'
              + '<div style="width: '+vColWidth+'px">' + vTmpDate.getDate() + '</div></td>';
            vItemRowStr  += '<td class="ganttDetail" style="background-color:#' + vWeekendColor + ';">'
               + '<div style="width: '+vColWidth+'px">&nbsp;&nbsp;</div></td>';
          } else {
            if( JSGantt.formatDateStr(vCurrDate,'mm/dd/yyyy') == JSGantt.formatDateStr(vTmpDate,'mm/dd/yyyy')) {
              vDateRowStr += '<td class="ganttRightSubTitle" style="background-color:#' + vCurrentdayColor + '" >'
               + '<div style="width: '+vColWidth+'px">' + vTmpDate.getDate() + '</div></td>';
              vItemRowStr += '<td class="ganttDetail" style="background-color:#' + vCurrentdayColor + '" >'
               + '<div style="width: '+vColWidth+'px">&nbsp;&nbsp;</div></td>';
            } else {
              vDateRowStr += '<td class="ganttRightSubTitle" >'
                + '<div style="width: '+vColWidth+'px">' + vTmpDate.getDate() + '</div></td>';
              vItemRowStr += '<td class="ganttDetail" ><div style="width: '+vColWidth+'px">&nbsp;&nbsp;</div></td>';
            }
          }
          vTmpDate.setDate(vTmpDate.getDate() + 1);
        } else if (vFormat == 'week') {
          vNxtDate.setDate(vNxtDate.getDate() + 7);
          if( vCurrDate >= vTmpDate && vCurrDate < vNxtDate ) { 
            vDateRowStr += '<td class="ganttRightSubTitle" style="background-color:#' + vCurrentdayColor + '">'
              + '<div style="width: '+vColWidth+'px">' 
              + JSGantt.formatDateStr(vTmpDate,"week-firstday",vMonthArr) + '</div></td>';
            vItemRowStr += '<td class="ganttDetail" style="background-color:#' + vCurrentdayColor + '">'
              + '<div style="width: '+vColWidth+'px">&nbsp;&nbsp;</div></td>';
          } else {
            vDateRowStr += '<td class="ganttRightSubTitle">'
              + '<div style="width: '+vColWidth+'px">' 
              + JSGantt.formatDateStr(vTmpDate,"week-firstday",vMonthArr) + '</div></td>';
            vItemRowStr += '<td class="ganttDetail" >' 
              + '<div style="width: '+vColWidth+'px">&nbsp;&nbsp;</div></td>';
          }
          vTmpDate.setDate(vTmpDate.getDate() + 7);
        } else if (vFormat == 'month') {
          vNxtDate.setFullYear(vTmpDate.getFullYear(), vTmpDate.getMonth(), vMonthDaysArr[vTmpDate.getMonth()]);
          if( vCurrDate >= vTmpDate && vCurrDate < vNxtDate ) {
            vDateRowStr += '<td class="ganttRightSubTitle" style="background-color:#' + vCurrentdayColor + '"> '
              + '<div style="width: '+vColWidth+'px">' 
              + JSGantt.formatDateStr(vTmpDate,"month-long",vMonthArr) + '</div></td>';
            vItemRowStr += '<td class="ganttDetail" style="background-color:#' + vCurrentdayColor + '">'
              +'<div style="width: '+vColWidth+'px">&nbsp;&nbsp;</div></td>';
          } else {
            vDateRowStr += '<td class="ganttRightSubTitle"> '
              + '<div style="width: '+vColWidth+'px">' 
              + JSGantt.formatDateStr(vTmpDate,"month-long",vMonthArr) + '</div></td>';
            vItemRowStr += '<td class="ganttDetail" >'
              + '<div style="width: '+vColWidth+'px">&nbsp;&nbsp;</div></td>';
          }         
          vTmpDate.setDate(vTmpDate.getDate() + 1);
          while(vTmpDate.getDate() > 1) {
            vTmpDate.setDate(vTmpDate.getDate() + 1);
          }
        } else if (vFormat == 'quarter') {
          vNxtDate.setDate(vNxtDate.getDate() + 122);
          if( vTmpDate.getMonth()==0 || vTmpDate.getMonth()==1 || vTmpDate.getMonth()==2 ) {
            vNxtDate.setFullYear(vTmpDate.getFullYear(), 2, 31);
          } else if( vTmpDate.getMonth()==3 || vTmpDate.getMonth()==4 || vTmpDate.getMonth()==5 ) {
            vNxtDate.setFullYear(vTmpDate.getFullYear(), 5, 30);
          } else if( vTmpDate.getMonth()==6 || vTmpDate.getMonth()==7 || vTmpDate.getMonth()==8 ) {
            vNxtDate.setFullYear(vTmpDate.getFullYear(), 8, 30);
          } else if( vTmpDate.getMonth()==9 || vTmpDate.getMonth()==10 || vTmpDate.getMonth()==11 ) {
            vNxtDate.setFullYear(vTmpDate.getFullYear(), 11, 31);
          }
          if( vCurrDate >= vTmpDate && vCurrDate < vNxtDate ) {
            vDateRowStr += '<td class="ganttRightSubTitle" style="background-color:#' + vCurrentdayColor + '" >'
              +'<div style="width: '+vColWidth+'px">Qtr. ' + vQuarterArr[vTmpDate.getMonth()] + '</div></td>';
            vItemRowStr += '<td class="ganttDetail" style="background-color:#' + vCurrentdayColor + '">'
              + '<div style="width: '+vColWidth+'px">&nbsp;&nbsp;</div></td>';
          } else {
            vDateRowStr += '<td class="ganttRightSubTitle" >'
              +'<div style="width: '+vColWidth+'px">Qtr. ' + vQuarterArr[vTmpDate.getMonth()] + '</div></td>';
            vItemRowStr += '<td class="ganttDetail" >'
              + '<div style="width: '+vColWidth+'px">&nbsp;&nbsp;</div></td>';
          }        
          vTmpDate.setDate(vTmpDate.getDate() + 81);
          while(vTmpDate.getDate() > 1) {
            vTmpDate.setDate(vTmpDate.getDate() + 1);
          }
        }
      }
      vTopRightTable += vDateRowStr + '</TR>';
      vTopRightTable += '</TBODY></TABLE></DIV>';
      for(i = 0; i < vTaskList.length; i++) {
        vTmpDate.setFullYear(vMinDate.getFullYear(), vMinDate.getMonth(), vMinDate.getDate());
        vTaskStart = vTaskList[i].getStart();
        vTaskEnd   = vTaskList[i].getEnd();
        vTaskRealEnd = vTaskList[i].getRealEnd();
        vTaskPlanStart = vTaskList[i].getPlanStart();
        if (vTaskList[i].getGroup() && vTaskEnd==null && vTaskRealEnd!=null)vTaskEnd=vTaskRealEnd;
        vNumCols = 0;
        vID = vTaskList[i].getID();
        vNumUnits = (vTaskList[i].getEnd() - vTaskList[i].getStart()) / (24 * 60 * 60 * 1000) + 1;
        if(vTaskList[i].getVisible() == 0) {
          vRightTable += '<DIV id=childgrid_' + vID + ' style="position:relative; display:none;">';
        } else {
          vRightTable += '<DIV id=childgrid_' + vID + ' style="position:relative;">';
        }
        if( vTaskList[i].getMile() ) {
          vRightTable += '<DIV ' + ffSpecificHeight+ '>'
            + '<TABLE style="position:relative; top:0px; width: ' + vChartWidth + 'px; " >' 
            + '<TR id=childrow_' + vID + ' class="ganttTaskmile" '
            + ' onMouseover=JSGantt.ganttMouseOver(' + vID + ',"right","mile") ' 
            + ' onMouseout=JSGantt.ganttMouseOut(' + vID + ',"right","mile")>' + vItemRowStr + '</TR></TABLE></DIV>';
          vDateRowStr = JSGantt.formatDateStr(vTaskStart,vDateDisplayFormat);
          //vTaskLeft = ( (Date.parse(vTaskList[i].getStart()) - Date.parse(vMinDate))  / (24 * 60 * 60 * 1000)) ;
          //if (vMinDate>vDefaultMinDate) {
          // vTaskLeft = vTaskLeft - 1;
          //}
          vTaskLeft = Math.ceil((Date.parse(vTaskList[i].getStart()) - Date.parse(vMinDate)) / (24 * 60 * 60 * 1000) );
          //if (vMinDate>vDefaultMinDate) {
            vTaskLeft = vTaskLeft - 0.85;
          //}
          vTaskRight = 1;
          if (vTaskStart && vTaskEnd && Date.parse(vMaxDate)>=Date.parse(vTaskList[i].getEnd())) {
        	  vBardivName='bardiv_' + vID;
          } else {
        	  vBardivName='outbardiv_' + vID;
          }	  
          vRightTable += '<div id=' + vBardivName + ' style="position:absolute; top:-2px; ' 
            + 'color:#' + vTaskList[i].getColor() + ';' 
            + 'left:' + Math.ceil(vTaskLeft * (vDayWidth)) + 'px; overflow:hidden;">' 
            + ' <div id=taskbar_' + vID + ' title="' + vTaskList[i].getName() + ': ' + vDateRowStr + '" '
            + ' style="overflow:hidden; cursor: pointer; font-size:18px;" '
            + ' onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");>';
          if (vTaskStart && vTaskEnd && Date.parse(vMaxDate)>=Date.parse(vTaskList[i].getEnd())) {
            if(vTaskList[i].getCompVal() < 100) {
              vRightTable += '&loz;</div>' ;
            } else { 
              vRightTable += '&diams;</div>' ;
            }          
            if( g.getCaptionType() ) {
              vCaptionStr = '';
              switch( g.getCaptionType() ) {           
                case 'Caption':    vCaptionStr = vTaskList[i].getCaption();  break;
                case 'Resource':   vCaptionStr = vTaskList[i].getResource();  break;
                case 'Duration':   vCaptionStr = vTaskList[i].getDuration(vFormat);  break;
                case 'Complete':   vCaptionStr = vTaskList[i].getCompStr();  break;
                case 'Work':       vCaptionStr = vTaskList[i].getWork();  break;
              }
              vRightTable += '<div position:absolute; top:2px; width:120px; left:12px">' + vCaptionStr + '</div>';
            }
          } else {
        	  vRightTable += '</div>' ;  
          }
          vRightTable += '</div>';
        } else {
          vDateRowStr = JSGantt.formatDateStr(vTaskStart,vDateDisplayFormat) + ' - ' 
            + JSGantt.formatDateStr(vTaskEnd,vDateDisplayFormat);
          vTmpEnd=(Date.parse(vMaxDate)<Date.parse(vTaskEnd))?vMaxDate:vTaskEnd;
          vTaskRight = (Date.parse(vTmpEnd) - Date.parse(vTaskStart)) / (24 * 60 * 60 * 1000) + 1 ;
          vTaskLeft = Math.ceil((Date.parse(vTaskStart) - Date.parse(vMinDate)) / (24 * 60 * 60 * 1000) );
          vTaskLeft = vTaskLeft - 1;
          var vBarLeft=Math.ceil(vTaskLeft * (vDayWidth));
          var vBarWidth=Math.ceil((vTaskRight) * (vDayWidth) );
          //if (vBarWidth<10) vBarWidth=10;
   
          if (g.getSplitted()==true && !vTaskList[i].getGroup()) {
              var vTmpEndReal=(Date.parse(vMaxDate)<Date.parse(vTaskList[i].getRealEnd()))?vMaxDate:vTaskList[i].getRealEnd();
              vTaskRightReal = (Date.parse(vTmpEndReal) - Date.parse(vTaskList[i].getStart())) / (24 * 60 * 60 * 1000) + 1 ;
              vTaskLeftPlan = Math.ceil((Date.parse(vTaskList[i].getPlanStart()) - Date.parse(vMinDate)) / (24 * 60 * 60 * 1000) );
              vTaskLeftPlan = vTaskLeftPlan - 1;
              var vBarLeftPlan=Math.ceil(vTaskLeftPlan * (vDayWidth))- vBarLeft ;
              var vBarWidthPlan=Math.ceil(((vTaskRight-vTaskLeftPlan+vTaskLeft) * (vDayWidth)) );
              var vBarWidthReal=Math.ceil((vTaskRightReal) * (vDayWidth) );
              vBarWidth=vBarWidth-1;
          }
          if( vTaskList[i].getGroup()) {            
            vRightTable += '<DIV ' + ffSpecificHeight+ '>'
              + '<TABLE style="position:relative; top:0px; width: ' + vChartWidth + 'px;">' 
              + '<TR id=childrow_' + vID + ' class="ganttTaskgroup" '
              + ' onMouseover=JSGantt.ganttMouseOver(' + vID + ',"right","group") '
              + ' onMouseout=JSGantt.ganttMouseOut(' + vID + ',"right","group")>' + vItemRowStr + '</TR></TABLE></DIV>';
	        if (vTaskStart && vTaskEnd && Date.parse(vMaxDate)>=Date.parse(vTaskList[i].getStart()) ) {
	          vBardivName='bardiv_' + vID;
	        } else {
	          vBardivName='outbardiv_' + vID;
	        }	 
            vRightTable += '<div id=' + vBardivName + ' style="position:absolute; top:5px; '
                + ' left:' + vBarLeft + 'px; height: 7px; '
                + ' width:' + vBarWidth + 'px">';
            if (vTaskStart && vTaskEnd && Date.parse(vMaxDate)>=Date.parse(vTaskStart) ) {
              vRightTable += '<div id=taskbar_' + vID + ' title="' + vTaskList[i].getName() + ': ' + vDateRowStr + '" '
                + ' class="ganttTaskgroupBar" style="width:' + vBarWidth + 'px;">'
                + '<div style="width:' + vTaskList[i].getCompStr() + ';"' 
                + ' class="ganttGrouprowBarComplete" onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");>' 
                + '</div>' 
                + '</div>' 
                + '<div class="ganttTaskgroupBarExt" style="float:left; height:4px"></div>'               
                + '<div class="ganttTaskgroupBarExt" style="float:left; height:3px"></div>'                 
                + '<div class="ganttTaskgroupBarExt" style="float:left; height:2px"></div>'              
                + '<div class="ganttTaskgroupBarExt" style="float:left; height:1px"></div>' ;
              if (Date.parse(vMaxDate)>=Date.parse(vTaskEnd)) {
                vRightTable += '<div class="ganttTaskgroupBarExt" style="float:right; height:4px"></div>' 
                  + '<div class="ganttTaskgroupBarExt" style="float:right; height:3px"></div>'
                  + '<div class="ganttTaskgroupBarExt" style="float:right; height:2px"></div>' 
                  + '<div class="ganttTaskgroupBarExt" style="float:right; height:1px"></div>';  
              }
              if( g.getCaptionType() ) {
                vCaptionStr = '';
                switch( g.getCaptionType() ) {           
                  case 'Caption':    vCaptionStr = vTaskList[i].getCaption();  break;
                  case 'Resource':   vCaptionStr = vTaskList[i].getResource();  break;
                  case 'Duration':   vCaptionStr = vTaskList[i].getDuration(vFormat);  break;
                  case 'Complete':   vCaptionStr = vTaskList[i].getCompStr();  break;
                  case 'Work':       vCaptionStr = vTaskList[i].getWork();  break;
                }
                vRightTable += '<div class="ganttTaskgroupBarText" '
                  + 'style="left:' + (Math.ceil((vTaskRight) * (vDayWidth) - 1) + 6) + 'px">' + vCaptionStr + '</div>';
              }
            }
            vRightTable += '</div>';
          } else { // task (not a milestone, not a group)
            vDivStr = '<DIV ' + ffSpecificHeight+ '>'
              +'<TABLE style="position:relative; top:0px; width: ' + vChartWidth + 'px;" >' 
              +'<TR id=childrow_' + vID + ' class="ganttTaskrow" '
              +'  onMouseover=JSGantt.ganttMouseOver(' + vID + ',"right","row") '
              + ' onMouseout=JSGantt.ganttMouseOut(' + vID + ',"right","row")>' + vItemRowStr + '</TR></TABLE></DIV>';
            if (Date.parse(vMaxDate)>=Date.parse(vTaskList[i].getStart()) ) {
  	          vBardivName='bardiv_' + vID;
  	        } else {
  	          vBardivName='outbardiv_' + vID;
  	        }
            vRightTable += vDivStr;               
            vRightTable += '<div id=' + vBardivName + ' style="position:absolute; top:4px;'
                + ' border-bottom: 2px solid #' + vTaskList[i].getColor() + ';'
	            + ' left:' + vBarLeft + 'px; height:11px; '
	            + ' width:' + vBarWidth + 'px">';         
            vRightTable += ' <div class="ganttTaskrowBarComplete"  '
            	+ ' style="width:' + vTaskList[i].getCompStr() + '; cursor: pointer;"'
            	+ ' onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");>'
                + ' </div>'; 
	        if (Date.parse(vMaxDate)>=Date.parse(vTaskList[i].getStart())) {
	        	var tmpColor=vTaskList[i].getColor();
	        	if (g.getSplitted()) {
	        		tmpColor='999999';
	        		vBarWidth=vBarWidthReal;
	        	}
	        	vRightTable += '<div id=taskbar_' + vID + ' title="' + vTaskList[i].getName() + ': ' + vDateRowStr + '" '
	            + ' class="ganttTaskrowBar" style="background-color:#' + tmpColor +'; '
	            + ' width:' + vBarWidth + 'px; " ' 
	            + ' onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '"); >';
	            vRightTable += ' </div>';
	        	
	        	if (g.getSplitted()) {
	        		vRightTable +='<div class="ganttTaskrowBar"  title="' + vTaskList[i].getName() + ': ' + vDateRowStr + '" '
		        		  + 'style="position: absolute; background-color:#' + vTaskList[i].getColor() +';'
		        		  + 'top: 0px; width:' + vBarWidthPlan + 'px; left: ' + vBarLeftPlan + 'px; "'
		        		  + ' onclick=JSGantt.taskLink("' + vTaskList[i].getLink() + '");></div>';
		        	}
              if( g.getCaptionType() ) {
               vCaptionStr = '';
                switch( g.getCaptionType() ) {           
                  case 'Caption':    vCaptionStr = vTaskList[i].getCaption();  break;
                  case 'Resource':   vCaptionStr = vTaskList[i].getResource();  break;
                  case 'Duration':   vCaptionStr = vTaskList[i].getDuration(vFormat);  break;
                  case 'Complete':   vCaptionStr = vTaskList[i].getCompStr();  break;
                  case 'Work':       vCaptionStr = vTaskList[i].getWork();  break;
                }
                vRightTable += '<div style="font-size:10px; position:absolute; top:0px; width:120px; left:' + (Math.ceil((vTaskRight) * (vDayWidth) - 1) + 6) + 'px">' + vCaptionStr + '</div>';
              }
	        }
            vRightTable += '</div>' ;
          }
        }
        vRightTable += '</DIV>';
      }
// console.log(vRightTable);
      dojo.byId("leftGanttChartDIV").innerHTML=vLeftTable;
      dojo.byId("rightGanttChartDIV").innerHTML=vRightTable;
      dojo.byId("topGanttChartDIV").innerHTML=vTopRightTable;
      dojo.parser.parse('leftGanttChartDIV');
      dojo.parser.parse('rightGanttChartDIV');
      dojo.parser.parse('topGanttChartDIV');
      dojo.byId('rightside').style.left='-'+(dojo.byId('rightGanttChartDIV').scrollLeft+1)+'px';
      dojo.byId('leftside').style.top='-'+(dojo.byId('rightGanttChartDIV').scrollTop)+'px';
      dojo.byId('ganttScale').style.left=(dojo.byId('leftGanttChartDIV').scrollLeft)+'px';
    }
    top.hideWait();
  }; // this.draw
   
}; // GanttChart


JSGantt.isIE = function () {
  if(dojo.isIE) {
    return true;
  } else {
    return false;
  }
};
  
/**
 * Recursively process task tree ... set min, max dates of parent tasks and
 * identfy task level.
 * 
 * @method processRows
 * @param pList
 *            {Array} - Array of TaskItem Objects
 * @param pID
 *            {Number} - task ID
 * @param pRow
 *            {Number} - Row in chart
 * @param pLevel
 *            {Number} - Current tree level
 * @param pOpen
 *            {Boolean}
 * @return void
 */ 
JSGantt.processRows = function(pList, pID, pRow, pLevel, pOpen) {
  var vMinDate = new Date();
  var vMaxDate = new Date();
  var vMinSet  = 0;
  var vMaxSet  = 0;
  var vList    = pList;
  var vLevel   = pLevel;
  var i        = 0;
  var vNumKid  = 0;
  var vCompSum = 0;
  var vVisible = pOpen;   
  for(i = 0; i < pList.length; i++) {
    if(pList[i].getParent() == pID || (pID==0 && i==0) ) {
      vVisible = pOpen;
      pList[i].setVisible(vVisible);
      if(vVisible==1 && pList[i].getOpen() == 0) {
        vVisible = 0;
      }
      pList[i].setLevel(vLevel);
      vNumKid++;
      if(pList[i].getGroup() == 1) {
        JSGantt.processRows(vList, pList[i].getID(), i, vLevel+1, vVisible);
      };
      if( vMinSet==0 || pList[i].getStart() < vMinDate) {
        vMinDate = pList[i].getStart();
        vMinSet = 1;
      };
      if( vMaxSet==0 || pList[i].getEnd() > vMaxDate) {
        vMaxDate = pList[i].getEnd();
        vMaxSet = 1;
      };
      vCompSum += pList[i].getCompVal();
    }
  }
  if(pRow >= 0) {
    if (vMinDate==null) {
      if (vMaxDate==null) {
        vMinDate = new Date();
        vMaxDate = new Date();
      } else {
        vMinDate = vMaxDate;
      }
    } else {
      if (vMaxDate==null) {
        vMaxDate=vMinDate;
      }
    }    
    // pList[pRow].setStart(vMinDate);
    // pList[pRow].setEnd(vMaxDate);
    pList[pRow].setNumKid(vNumKid);
    // pList[pRow].setCompVal(Math.ceil(vCompSum/vNumKid));
  }
};

/**
 * Determine the minimum date of all tasks and set lower bound based on format
 * 
 * @method getMinDate
 * @param pList
 *            {Array} - Array of TaskItem Objects
 * @param pFormat
 *            {String} - current format (minute,hour,day...)
 * @return {Datetime}
 */
JSGantt.getMinDate = function getMinDate(pList, pFormat, pStartDateView) {
  var vDate = new Date();
  // vDate.setFullYear(pList[0].getStart().getFullYear(),
  // pList[0].getStart().getMonth(), pList[0].getStart().getDate());
  // Parse all Task End dates to find min
  for(i = 0; i < pList.length; i++) {
    if(pList[i].getStart()!=null && Date.parse(pList[i].getStart()) < Date.parse(vDate)) {
      vDate.setFullYear(pList[i].getStart().getFullYear(), pList[i].getStart().getMonth(), pList[i].getStart().getDate());
    }
  }
  if (pStartDateView && vDate<pStartDateView) {
    vDate=g.getStartDateView();
  }
  // Adjust min date to specific format boundaries (first of week or first of
  // month)
  if ( pFormat== 'minute') {
    vDate.setHours(0);
    vDate.setMinutes(0);
  } else if (pFormat == 'hour' ) {
    vDate.setHours(0);
    vDate.setMinutes(0);
  } else if (pFormat=='day') {   
    //vDate.setDate(vDate.getDate() - 1);
    while(vDate.getDay() % 7 != 1) {
      vDate.setDate(vDate.getDate() - 1);
    }
  } else if (pFormat=='week') {
    //vDate.setDate(vDate.getDate() - 1);
    while(vDate.getDay() % 7 != 1) {
      vDate.setDate(vDate.getDate() - 1);
    }
  } else if (pFormat=='month') {
    while(vDate.getDate() > 1) {
      vDate.setDate(vDate.getDate() - 1);
    }
  } else if (pFormat=='quarter') {
    if( vDate.getMonth()==0 || vDate.getMonth()==1 || vDate.getMonth()==2 ) {
      vDate.setFullYear(vDate.getFullYear(), 0, 1);
    } else if ( vDate.getMonth()==3 || vDate.getMonth()==4 || vDate.getMonth()==5 ) {
      vDate.setFullYear(vDate.getFullYear(), 3, 1);
    } else if( vDate.getMonth()==6 || vDate.getMonth()==7 || vDate.getMonth()==8 ) {
      vDate.setFullYear(vDate.getFullYear(), 6, 1);
    } else if( vDate.getMonth()==9 || vDate.getMonth()==10 || vDate.getMonth()==11 ) {
      vDate.setFullYear(vDate.getFullYear(), 9, 1);
    }
  };
  return(vDate);
};

/**
 * Used to determine the minimum date of all tasks and set lower bound based on
 * format
 * 
 * @method getMaxDate
 * @param pList
 *            {Array} - Array of TaskItem Objects
 * @param pFormat
 *            {String} - current format (minute,hour,day...)
 * @return {Datetime}
 */
JSGantt.getMaxDate = function (pList, pFormat, pEndDateView)
{
  var vDate = new Date();
  // vDate.setFullYear(pList[0].getEnd().getFullYear(),
  // pList[0].getEnd().getMonth(), pList[0].getEnd().getDate());
  // Parse all Task End dates to find max
  for(i = 0; i < pList.length; i++) {
    if(pList[i].getEnd()!=null && Date.parse(pList[i].getEnd()) > Date.parse(vDate)) {
      // vDate.setFullYear(pList[0].getEnd().getFullYear(),
    // pList[0].getEnd().getMonth(), pList[0].getEnd().getDate());
      vDate.setTime(Date.parse(pList[i].getEnd()));
    }  
  }
  if (pEndDateView && vDate>pEndDateView) {
	vDate=g.getEndDateView();
  }
  if (pFormat == 'minute') {
    vDate.setHours(vDate.getHours() + 1);
    vDate.setMinutes(59);
  }  else if (pFormat == 'hour') {
    vDate.setHours(vDate.getHours() + 2);
  }  else if (pFormat=='day') {      
  // Adjust max date to specific format boundaries (end of week or end of
  // month)
    //vDate.setDate(vDate.getDate() + 1);
    while(vDate.getDay() != 0) {
      vDate.setDate(vDate.getDate() + 1);
    }
  } else if (pFormat=='week') {
    vDate.setDate(vDate.getDate() + 2);
    while(vDate.getDay() != 0) {
      vDate.setDate(vDate.getDate() + 1);
    }
  } else if (pFormat=='month') {
     // Set to last day of current Month
      while(vDate.getDate() > 1) {
       vDate.setDate(vDate.getDate() + 1);
     }
    vDate.setDate(vDate.getDate() - 1);
  } else if (pFormat=='quarter') {
 // Set to last day of current Quarter
    if ( vDate.getMonth()==0 || vDate.getMonth()==1 || vDate.getMonth()==2 ) {
      vDate.setFullYear(vDate.getFullYear(), 2, 31);
    } else if ( vDate.getMonth()==3 || vDate.getMonth()==4 || vDate.getMonth()==5 ) {
      vDate.setFullYear(vDate.getFullYear(), 5, 30);
    } else if ( vDate.getMonth()==6 || vDate.getMonth()==7 || vDate.getMonth()==8 ) {
      vDate.setFullYear(vDate.getFullYear(), 8, 30);
    } else if( vDate.getMonth()==9 || vDate.getMonth()==10 || vDate.getMonth()==11 ) {
      vDate.setFullYear(vDate.getFullYear(), 11, 31);
    }
  }
  return(vDate);
};


/**
 * Returns an object from the current DOM
 * 
 * @method findObj
 * @param theObj
 *            {String} - Object name
 * @param theDoc
 *            {Document} - current document (DOM)
 * @return {Object}
 */
JSGantt.findObj = function (theObj, theDoc) {
  return dojo.byId(theObj);
};


/**
 * Change display format of current gantt chart
 * 
 * @method changeFormat
 * @param pFormat
 *            {String} - Current format (minute,hour,day...)
 * @param ganttObj
 *            {GanttChart} - The gantt object
 * @return {void}
 */
JSGantt.changeFormat = function(pFormat,ganttObj) {
  if(ganttObj) {
	top.showWait();  
    if (ganttObj.getFormat()=='month' && ganttObj.getEndDateView() ) {
      ganttObj.setFormat(pFormat);
	  refreshJsonPlanning();
	} else {
      ganttObj.resetStartDateView();
      ganttObj.resetEndDateView();
      ganttObj.setFormat(pFormat);
      ganttObj.DrawDependencies();
	}
    top.hideWait();
  } else {
    alert('Chart undefined');
  };
  
};


/**
 * Open/Close and hide/show children of specified task
 * 
 * @method folder
 * @param pID
 *            {Number} - Task ID
 * @param ganttObj
 *            {GanttChart} - The gantt object
 * @return {void}
 */
JSGantt.folder= function (pID,ganttObj) {
  var vList = ganttObj.getList();
  for(i = 0; i < vList.length; i++) {
    if(vList[i].getID() == pID) {
      if( vList[i].getOpen() == 1 ) {
        vList[i].setOpen(0);
        JSGantt.hide(pID,ganttObj);
        JSGantt.findObj('group_'+pID).className = "ganttExpandClosed";
        saveCollapsed(vList[i].getScope());
      } else {
        vList[i].setOpen(1);
        JSGantt.show(pID, ganttObj);
        JSGantt.findObj('group_'+pID).className = "ganttExpandOpened";
        saveExpanded(vList[i].getScope());
      }
    }
  }
};

JSGantt.collapse= function (ganttObj) {
  var vList = ganttObj.getList();
  for(i = vList.length -1; i >=0 ; i--) {
    if (vList[i].getGroup()) {
	  if (vList[i].getOpen()) {
		JSGantt.folder(vList[i].getID(),ganttObj);
	  }      
    }
  }
  ganttObj.DrawDependencies();
};
JSGantt.expand= function (ganttObj) {
  JSGantt.collapse(ganttObj);
  var vList = ganttObj.getList();
  //for(i = 0; i < vList.length; i++) {
  for(i = vList.length -1; i >=0 ; i--) {
    if(vList[i].getGroup()) {
      if (! vList[i].getOpen()) {
    	  JSGantt.folder(vList[i].getID(),ganttObj);
      }
    }
  }
  ganttObj.DrawDependencies();
};
	
/**
 * Hide children of a task
 * 
 * @method hide
 * @param pID
 *            {Number} - Task ID
 * @param ganttObj
 *            {GanttChart} - The gantt object
 * @return {void}
 */
JSGantt.hide=function (pID,ganttObj) {
   var vList=ganttObj.getList();
   var vID=0;
   for(var i = 0; i < vList.length; i++) {
     if(vList[i].getParent()==pID) {
       vID = vList[i].getID();
       JSGantt.findObj('child_' + vID).style.display = "none";
       JSGantt.findObj('childgrid_' + vID).style.display = "none";
       vList[i].setVisible(0);
       if(vList[i].getGroup() == 1) {
         JSGantt.hide(vID,ganttObj);
       }
     }
   }
};

/**
 * Show children of a task
 * 
 * @method show
 * @param pID
 *            {Number} - Task ID
 * @param ganttObj
 *            {GanttChart} - The gantt object
 * @return {void}
 */
JSGantt.show =  function (pID, ganttObj) {
  var vList = ganttObj.getList();
  var vID   = 0;
  var pIDindex=0;
  for(var i = 0; i < vList.length; i++) {
    if (vList[i].getID()==pID) {
      pIDindex=i;
    }
    if(vList[i].getParent() == pID) {
      vID = vList[i].getID();
      if (vList[pIDindex].getOpen()==1) {
        JSGantt.findObj('child_'+vID).style.display = "";
        JSGantt.findObj('childgrid_'+vID).style.display = "";
        vList[i].setVisible(1);
      }
      if(vList[i].getGroup() == 1 && vList[i].getVisible()) {
        JSGantt.show(vID, ganttObj);
      }
    }
  }
};

/**
 * Handles click events on task name, currently opens a new window
 * 
 * @method taskLink
 * @param pRef
 *            {String} - Javascript code to be executed !!! Must not include "
 *            char // BABYNUS 2009-09-10 : change text // BABYNUS 2009-09-10 :
 *            remove 2 lines
 * @return {void}
 */
JSGantt.taskLink = function(pRef){
  eval(pRef); // BABYNUS 2009-09-10 : add this line
};

/**
 * Parse dates based on gantt date format setting as defined in
 * JSGantt.GanttChart.setDateInputFormat()
 * 
 * @method parseDateStr
 * @param pDateStr
 *            {String} - A string that contains the date (i.e. "01/01/09")
 * @param pFormatStr
 *            {String} - The date format (mm/dd/yyyy,dd/mm/yyyy,yyyy-mm-dd)
 * @return {Datetime}
 */
JSGantt.parseDateStr = function(pDateStr,pFormatStr) {
  if (pDateStr==null || pDateStr=='' || pDateStr==' ') return null;
  var vDate =new Date();  
  // vDate.setTime( Date.parse(pDateStr));
  switch(pFormatStr) {
    case 'mm/dd/yyyy':
      var vDateParts = pDateStr.split('/');
      if (vDateParts.length==3) {
        vDate.setFullYear(parseInt(vDateParts[2], 10), parseInt(vDateParts[0], 10) - 1, parseInt(vDateParts[1], 10));
      }
      break;
    case 'dd/mm/yyyy':
      var vDateParts = pDateStr.split('/');
      if (vDateParts.length==3) {
        vDate.setFullYear(parseInt(vDateParts[2], 10), parseInt(vDateParts[1], 10) - 1, parseInt(vDateParts[0], 10));
      }
      break;
    case 'yyyy-mm-dd':
      var vDateParts = pDateStr.split('-');
      if (vDateParts.length==3) {
        vDate.setFullYear(parseInt(vDateParts[0], 10), parseInt(vDateParts[1], 10) - 1, parseInt(vDateParts[2], 10)); // BABYNUS
                                                            // CORRECTION
      }
      break;
  }
  return(vDate);  
};

/**
 * Display a formatted date based on gantt date format setting as defined in
 * JSGantt.GanttChart.setDateDisplayFormat()
 * 
 * @method formatDateStr
 * @param pDate
 *            {Date} - A javascript date object
 * @param pFormatStr
 *            {String} - The date format (mm/dd/yyyy,dd/mm/yyyy,yyyy-mm-dd...)
 * @return {String}
 */
JSGantt.formatDateStr = function(pDate,pFormatStr, vMonthArray) {
  if (pDate==null || pDate=='') return '-';
  var vYear4Str = pDate.getFullYear() + '';
   var vYear2Str = vYear4Str.substring(2,4);
  var vMonthStr = (pDate.getMonth()+1) + '';
  if (vMonthStr.length==1) vMonthStr="0"+vMonthStr;
  var vDayStr   = pDate.getDate() + '';
  if (vDayStr.length==1) vDayStr="0"+vDayStr;
  var onejan = new Date(pDate.getFullYear(),0,1);
  // var vWeekNum = Math.ceil((((pDate - onejan) / 86400000) +
  // onejan.getDay()+1)/7) + '';
  //var vWeekNum = dojo.date.locale.format(pDate, {datePattern: "w", selector: "date"});
  var vWeekNum = dateGetWeek(pDate,1);
  var vDateStr = "";  
  switch(pFormatStr) {
    case 'default':
      return dojo.date.locale.format(pDate, {formatLength: "short", fullYear: true, selector: "date"});
    case 'mm/dd/yyyy':
      return( vMonthStr + '/' + vDayStr + '/' + vYear4Str );
    case 'dd/mm/yyyy':
      return( vDayStr + '/' + vMonthStr + '/' + vYear4Str );
    case 'yyyy-mm-dd':
      return( vYear4Str + '-' + vMonthStr + '-' + vDayStr );
    case 'mm/dd/yy':
       return( vMonthStr + '/' + vDayStr + '/' + vYear2Str );
    case 'dd/mm/yy':
      eturn( vDayStr + '/' + vMonthStr + '/' + vYear2Str );
    case 'yy-mm-dd':
      return( vYear2Str + '-' + vMonthStr + '-' + vDayStr );
    case 'mm/dd':
      return( vMonthStr + '/' + vDayStr );
    case 'dd/mm':
      return( vDayStr + '/' + vMonthStr );
    case 'week-long':
      return ( '' + vYear4Str + " #" + vWeekNum + ' ('  + vMonthArray[pDate.getMonth()].substr(0,4) + ') ');
    case 'week-short':
      return ( vYear2Str + ' #'  + vWeekNum  );
    case 'week-firstday':
      if (dojo.locale.substring(0,2)=="fr") {
        return (  vDayStr + '/' + vMonthStr );
      } else {
        return ( vMonthStr + '/'  + vDayStr );
      }
    case 'year-long':
      return ( vYear4Str + '');
    case 'month-long':
      return ( vMonthArray[pDate.getMonth()].substr(0,10) + '' );      
  }  
};

/**
 * Specific funtion to get Week Number
 */
Date.prototype.getWeek = function() {
  var onejan = new Date(this.getFullYear(),0,1);
  return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
};

/**
 * Parse an external XML file containing task items.
 * 
 * @method parseXML
 * @param ThisFile
 *            {String} - URL to XML file
 * @param pGanttVar
 *            {Gantt} - Gantt object
 * @return {void}
 */
JSGantt.parseXML = function(ThisFile,pGanttVar){
  var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;   // Is
                                        // this
                                        // Chrome
  try { // Internet Explorer
    xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
  }
  catch(e) {
    try { // Firefox, Mozilla, Opera, Chrome etc.
      if (is_chrome==false) {  xmlDoc=document.implementation.createDocument("","",null); }
    }
    catch(e) {
      alert(e.message);
      return;
    }
  }
  if (is_chrome==false) {   // can't use xmlDoc.load in chrome at the moment
    xmlDoc.async=false;
    xmlDoc.load(ThisFile);    // we can use loadxml
    JSGantt.AddXMLTask(pGanttVar);
    xmlDoc=null;      // a little tidying
    Task = null;
  }
  else {
    JSGantt.ChromeLoadXML(ThisFile,pGanttVar);  
    ta=null;  // a little tidying
  }
};

/**
 * Add a task based on parsed XML doc
 * 
 * @method AddXMLTask
 * @param pGanttVar
 *            {Gantt} - Gantt object
 * @return {void}
 */
JSGantt.AddXMLTask = function(pGanttVar){
  Task=xmlDoc.getElementsByTagName("task");
  var n = xmlDoc.documentElement.childNodes.length;  // the number of tasks.
                            // IE gets this right,
                            // but mozilla add extra
                            // ones (Whitespace)
  for(var i=0;i<n;i++) {
    // optional parameters may not have an entry (Whitespace from mozilla
    // also returns an error )
    // Task ID must NOT be zero other wise it will be skipped
    try { pID = Task[i].getElementsByTagName("pID")[0].childNodes[0].nodeValue;
    } catch (error) {pID =0;}
    pID *= 1;  // make sure that these are numbers rather than strings in
          // order to make jsgantt.js behave as expected.
    if(pID!=0){
       try { 
         pName = Task[i].getElementsByTagName("pName")[0].childNodes[0].nodeValue;
      } catch (error) {
        pName ="No Task Name";
      }      // If there is no corresponding entry in the XML file the
          // set a default.
      try { 
        pColor = Task[i].getElementsByTagName("pColor")[0].childNodes[0].nodeValue;
      } catch (error) {
        pColor ="0000ff";
      }
      try { 
        pParent = Task[i].getElementsByTagName("pParent")[0].childNodes[0].nodeValue;
      } catch (error) {
        pParent =0;
      }
      pParent *= 1;
      try { 
        pStart = Task[i].getElementsByTagName("pStart")[0].childNodes[0].nodeValue;
      } catch (error) {
        pStart ="";
      }
      try { 
        pEnd = Task[i].getElementsByTagName("pEnd")[0].childNodes[0].nodeValue;
      } catch (error) { 
        pEnd ="";
      }
      try { 
        pLink = Task[i].getElementsByTagName("pLink")[0].childNodes[0].nodeValue;
      } catch (error) { 
        pLink ="";
      }
      try { 
        pMile = Task[i].getElementsByTagName("pMile")[0].childNodes[0].nodeValue;
      } catch (error) { 
        pMile=0;
      }
      pMile *= 1;
      try { 
        pRes = Task[i].getElementsByTagName("pRes")[0].childNodes[0].nodeValue;
      } catch (error) { 
        pRes ="";
      }
      try { 
        pComp = Task[i].getElementsByTagName("pComp")[0].childNodes[0].nodeValue;
      } catch (error) {
        pComp =0;
      }
      pComp *= 1;
      try { 
        pGroup = Task[i].getElementsByTagName("pGroup")[0].childNodes[0].nodeValue;
      } catch (error) {
        pGroup =0;
      }
      pGroup *= 1;
      try { 
        pOpen = Task[i].getElementsByTagName("pOpen")[0].childNodes[0].nodeValue;
      } catch (error) { 
        pOpen =1;
      }
      pOpen *= 1;
      try { 
        pDepend = Task[i].getElementsByTagName("pDepend")[0].childNodes[0].nodeValue;
      } catch (error) { 
        pDepend =0;
      }
      if (pDepend.length==0){
        pDepend='';
      } // need this to draw the dependency lines
      try { 
        pCaption = Task[i].getElementsByTagName("pCaption")[0].childNodes[0].nodeValue;
      } catch (error) { 
        pCaption ="";
      }
      // Finally add the task
      pGanttVar.AddTaskItem(new JSGantt.TaskItem(pID , pName, pStart, pEnd, pColor,  pLink, pMile, pRes,  pComp, pGroup, pParent, pOpen, pDepend,pCaption));
    }
  }
};

/**
 * Load an XML document in Chrome
 * 
 * @method ChromeLoadXML
 * @param ThisFile
 *            {String} - URL to XML file
 * @param pGanttVar
 *            {Gantt} - Gantt object
 * @return {void}
 */
JSGantt.ChromeLoadXML = function(ThisFile,pGanttVar){
// Thanks to vodobas at mindlence,com for the initial pointers here.
  XMLLoader = new XMLHttpRequest();
  XMLLoader.onreadystatechange= function(){
    JSGantt.ChromeXMLParse(pGanttVar);
  };
  XMLLoader.open("GET", ThisFile, false);
  XMLLoader.send(null);
};

/**
 * Parse XML document in Chrome
 * 
 * @method ChromeXMLParse
 * @param pGanttVar
 *            {Gantt} - Gantt object
 * @return {void}
 */
JSGantt.ChromeXMLParse = function (pGanttVar){
// Manually parse the file as it is loads quicker
  if (XMLLoader.readyState == 4) {
    var ta=XMLLoader.responseText.split(/<task>/gi);
    var n = ta.length;  // the number of tasks.
    for(var i=1;i<n;i++) {
      Task = ta[i].replace('/<[/]p/g', '<p');  
      var te = Task.split(/<pid>/i);  
      if(te.length> 2){
        var pID=te[1];
      } else {
        var pID = 0;
      }
      pID *= 1;
      var te = Task.split(/<pName>/i);
      if(te.length> 2){
        var pName=te[1];
      } else {
        var pName = "No Task Name";
      }
      var te = Task.split(/<pstart>/i);
      if(te.length> 2){
        var pStart=te[1];
      } else {
        var pStart = "";
      }  
      var te = Task.split(/<pEnd>/i);
      if(te.length> 2){
        var pEnd=te[1];
      } else {
        var pEnd = "";
      }  
      var te = Task.split(/<pColor>/i);
      if(te.length> 2){
        var pColor=te[1];
      } else {
        var pColor = '0000ff';
      }
      var te = Task.split(/<pLink>/i);
      if(te.length> 2){
        var pLink=te[1];
      } else {
        var pLink = "";
      }
      var te = Task.split(/<pMile>/i);
      if(te.length> 2){
        var pMile=te[1];
      } else {
        var pMile = 0;
      }
      pMile  *= 1;
      var te = Task.split(/<pRes>/i);
      if(te.length> 2){
        var pRes=te[1];
      } else {
        var pRes = "";
      }  
      var te = Task.split(/<pComp>/i);
      if(te.length> 2){
        var pComp=te[1];
      } else {
        var pComp = 0;
      }  
      pComp  *= 1;  
      var te = Task.split(/<pGroup>/i);
      if(te.length> 2){
        var pGroup=te[1];
      } else {
        var pGroup = 0;
      }  
      pGroup *= 1;
      var te = Task.split(/<pParent>/i);
      if(te.length> 2){
        var pParent=te[1];
      } else {
        var pParent = 0;
      }  
      pParent *= 1;
      var te = Task.split(/<pOpen>/i);
      if(te.length> 2){
        var pOpen=te[1];
      } else {
        var pOpen = 1;
      }
      pOpen *= 1;  
      var te = Task.split(/<pDepend>/i);
      if(te.length> 2){
        var pDepend=te[1];
      } else {
        var pDepend = "";
      }  
      if (pDepend.length==0){
        pDepend='';
      } // need this to draw the dependency lines
      var te = Task.split(/<pCaption>/i);
      if(te.length> 2){
        var pCaption=te[1];
      } else {
        var pCaption = "";
      }
      // Finally add the task
      pGanttVar.AddTaskItem(new JSGantt.TaskItem(pID , pName, pStart, 
        pEnd, pColor,  pLink, pMile, pRes,  pComp, pGroup, pParent, pOpen, pDepend,pCaption   ));
    };
  };
};


JSGantt.benchMark = function(pItem){
  var vEndTime=new Date().getTime();
  alert(pItem + ': Elapsed time: '+((vEndTime-vBenchTime)/1000)+' seconds.');
  vBenchTime=new Date().getTime();
};

JSGantt.ganttMouseOver = function( pID, pPos, pType) {
  var vRowObj1 = JSGantt.findObj('child_' + pID);
  if (vRowObj1) vRowObj1.className = "ganttTask" + pType + " ganttRowHover";
  var vRowObj2 = JSGantt.findObj('childrow_' + pID);
  if (vRowObj2) vRowObj2.className = "ganttTask" + pType + " ganttRowHover";
};

JSGantt.ganttMouseOut = function(pID, pPos, pType) {
  var vRowObj1 = JSGantt.findObj('child_' + pID);
  if (vRowObj1) vRowObj1.className = "ganttTask" + pType;
  var vRowObj2 = JSGantt.findObj('childrow_' + pID);
  if (vRowObj2) vRowObj2.className = "ganttTask" + pType;
};

JSGantt.setSelected = function(pID) {
  var vRowObj1 = JSGantt.findObj('child_' + pID);
  if (vRowObj1) vRowObj1.className = "selectedrow" + pType;
  var vRowObj2 = JSGantt.findObj('childrow_' + pID);
  if (vRowObj2) vRowObj2.className = "selectedrow" + pType;
};

JSGantt.i18n = function (message) {
  return i18n(message);
};

JSGantt.drawFormat = function(vFormatArr, vFormat, vGanttVar, vPos) {
  var vLeftTable='<div style="position:relative;" id="ganttScale" class="ganttScale">';
  vLeftTable+='<span>';
  vLeftTable+='<button dojoType="dijit.form.Button" showlabel="false"'
	     +' title="' + i18n('buttonCollapse') + '"'
	     +' style="font-size:5px; text-align: center; position: relative; top: -1px;vertical-align: middle; height:16px; width:16px;"'
	     +' onclick=JSGantt.collapse('+vGanttVar+')'
	     +' iconClass="iconCollapse">'
	     +'</button>&nbsp;';
  vLeftTable+='</span><span >';
  vLeftTable+='<button dojoType="dijit.form.Button" showlabel="false"'
	     +' title="' + i18n('buttonExpand') + '"'
	     +' style="font-size:5px;position: relative; top: -1px;vertical-align: middle; height:16px; width:16px;"'
	     +' onclick=JSGantt.expand('+vGanttVar+')'
	     +' iconClass="iconExpand" >'
	     +'</button>&nbsp;';
  vLeftTable+='</span>&nbsp;';
  vLeftTable +='<b>' + JSGantt.i18n('periodScale') + '&nbsp;:&nbsp;&nbsp;</b>';
  if (vFormatArr.join().indexOf("day")!=-1) { 
    if (vFormat=='day') {
      vLeftTable += '<label class="ganttScale">'
    	+'<input type="RADIO" dojoType="dijit.form.RadioButton"'
    	+' name="radFormat' + vPos + '" value="day" checked>' 
    	+JSGantt.i18n('day')
    	+'</label>';
    } else {
      vLeftTable += '<label class="ganttScale" style="cursor:pointer;">'
    	+'<input type="RADIO" dojoType="dijit.form.RadioButton"'
    	+' name="radFormat' + vPos + '"' 
        +' onChange=JSGantt.changeFormat("day",'+vGanttVar+'); value="day">' 
        + JSGantt.i18n('day')
        + '</label>';
    }
    vLeftTable += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if (vFormatArr.join().indexOf("week")!=-1) { 
    if (vFormat=='week') {
      vLeftTable += '<label class="ganttScale">'
    	+'<input type="RADIO" dojoType="dijit.form.RadioButton" '
    	+' name="radFormat' + vPos + '" value="week" checked>' 
    	+JSGantt.i18n('week') 
    	+'</label>';
    } else {
      vLeftTable += '<label class="ganttScale" style="cursor:pointer">'
    	+'<input type="RADIO" dojoType="dijit.form.RadioButton"'
        +' name="radFormat' + vPos + '"' 
        +' onChange=JSGantt.changeFormat("week",'+vGanttVar+') value="week">'
        + JSGantt.i18n('week') 
        +'</label>';
    }
    vLeftTable += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if (vFormatArr.join().indexOf("month")!=-1) { 
    if (vFormat=='month') { 
      vLeftTable += '<label class="ganttScale">'
        +'<input type="RADIO" dojoType="dijit.form.RadioButton" '
        +'name="radFormat' + vPos + '" value="month" checked>' 
        +JSGantt.i18n('month')
        +'</label>';
    } else {
      vLeftTable += '<label class="ganttScale" style="cursor:pointer">'
    	+'<input type="RADIO" dojoType="dijit.form.RadioButton"'
    	+' name="radFormat' + vPos + '"' 
        + ' onChange=JSGantt.changeFormat("month",'+vGanttVar+') value="month">' 
        +JSGantt.i18n('month')
        +'</label>';
    }
    vLeftTable += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  if (vFormatArr.join().indexOf("quarter")!=-1) { 
    if (vFormat=='quarter') {
      vLeftTable += '<INPUT TYPE="RADIO" dojoType="dijit.form.RadioButton" NAME="radFormat' + vPos + '" VALUE="quarter" checked>' + JSGantt.i18n('quarter');
    } else {
      vLeftTable += '<INPUT TYPE="RADIO" dojoType="dijit.form.RadioButton" NAME="radFormat' + vPos + '"' 
      + ' onclick=JSGantt.changeFormat("quarter",'+vGanttVar+') VALUE="quarter">' + JSGantt.i18n('quarter');
    }
    vLeftTable += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  vLeftTable+='</div>';
  return vLeftTable;
};

function setGanttVisibility(g) {
	g.setShowRes(0);                       
	g.setShowDur(0);                       
	g.setShowComp(0);                      
	g.setShowStartDate(0);   
	g.setShowEndDate(0);   
	g.setShowValidatedWork(0);
	g.setShowAssignedWork(0);
	g.setShowRealWork(0);
	g.setShowLeftWork(0);
	g.setShowPlannedWork(0);
	for (iSort=0;iSort<planningColumnOrder.length; iSort++) {
		switch (planningColumnOrder[iSort]) {
		  case 'Resource' : g.setShowRes(1);break;                       
		  case 'Duration' : g.setShowDur(1); break;                 
		  case 'Progress' : g.setShowComp(1); break;             
		  case 'StartDate' : g.setShowStartDate(1);break;  
		  case 'EndDate' : g.setShowEndDate(1);break;   
		  case 'ValidatedWork' : g.setShowValidatedWork(1);break;
		  case 'AssignedWork' : g.setShowAssignedWork(1);break;
		  case 'RealWork' : g.setShowRealWork(1);break;
		  case 'LeftWork' : g.setShowLeftWork(1);break;
		  case 'PlannedWork' : g.setShowPlannedWork(1);break;
		}
	}
	if (dojo.byId('resourcePlanning')) {
	  g.setShowRes(0); 
	  g.setShowValidatedWork(0);
	}
	g.setSortArray(planningColumnOrder);
}