import Swal from 'sweetalert2';

export default ({ app, redirect }, inject) => {

    /*
        * FP  = Fat Percentage
        * MP  = Moisturizer Percentage
        * AFP = Accoumulate Fat Percentate (11.5)
        * PMP  = Powder Milk Percentage
        * PMFP = Powder Milk Fat Percentage
        * SFK = Standard Fat Kg
        * SFP = Standard Fat Percentage
        * SSNFK = Standard SNF Kg
        * SMK = Standard Milk KG
        * SFK = Standard Fat KG
        * SFP = Standard Fat Percentage
        * SSNFP = Standard SMF Percentage
        * SAFP  = Standard Accumulate Fat Percentage
    */
    inject('getSML', (RFK, FP, SAFP, RSNFK, PMP, PMFP)=>{
        if(RFK > 0 && FP > 0 && SAFP > 0 && RSNFK > 0 && PMP > 0 && PMFP > 0 && RFK > 0)
        {
            var result = (RFK / (FP/100) * (SAFP/100));

            result = (result - RSNFK);

            result = result / (PMP/100) * (PMFP/100);

            result = result + +RFK;
            //
            return result;
        }
        else return 0;
    });

    inject('getSMK', (SFK, SFP)=>{
        if(SFK > 0 && SFP > 0)
        {
            return (SFK/(SFP/100));
        }
        else return 0;
    });

    inject('getSMKWithL', (SML, DENSITY)=>{
        if(SML > 0 && DENSITY > 0)
        {
            return (SML * DENSITY);
        }
        else return 0;
    });

    inject('getSFKWithL', (SML, DENSITY, SFP)=>{
        if(SML > 0 && DENSITY > 0 && SFP > 0)
        {
            return ((app.$getSMKWithL(SML, DENSITY) / 100) * SFP);
        }
        else return 0; 
    });

    inject('getSSNFKWithL', (SML, DENSITY, SSNFP)=>{
        if(SML > 0 && DENSITY > 0 && SSNFP > 0)
        {
            return ((app.$getSMKWithL(SML, DENSITY) / 100) * SSNFP);
        }
        else return 0; //Number.parseFloat().toFixed(2);
    });

    inject('getSSNFK', (SMK, SSNFP)=>{
        if(SMK > 0 && SSNFP > 0)
        {
            return (SMK*(SSNFP/100));
        }
        else return 0;
    });

    inject('getPMSNFP', (FP, MP)=>{
        if(FP > 0 && MP > 0)
        {
            return (100 - (FP+MP));
        }
        else return 0;
    });

    inject('getSNFP', (SCLR, SFP)=>{
        if(SCLR > 0 && SFP > 0)
        {
            return ((SCLR/4) + (SFP/5) + 0.14);
        }
        else return 0;
    });

    inject('getSCLR', (AFP, FP)=>{
        if(+FP > 0 && +AFP > 0)
        {
            return ((+AFP - (FP/5))-0.14)*4;
        }
        else return 0;
    });

    //
    inject('clrDensity', (number, niddle='clr') => {
        if(niddle=='clr')
        {
            return ((number - 1) * 1000);
        }
        else if(niddle=='density')
        {
            return ((number / 1000) + 1);
        }
        return 0;
    });

    inject('en2bn', (number, f=0) => {
        var numbers = {
            0:'০',
            1:'১',
            2:'২',
            3:'৩',
            4:'৪',
            5:'৫',
            6:'৬',
            7:'৭',
            8:'৮',
            9:'৯',
        };
        number = !isNaN(number) ? (Number.parseFloat(number).toFixed(f))+'' : number;
        var output = [], number = (number)+'';
        for (var i = 0; i < number.length; ++i) {
            if (numbers.hasOwnProperty(number[i])) {
                output.push(numbers[number[i]]);
            } else {
                output.push(number[i]);
            }
        }
        return output.join('');
    });

    inject('logout', ()=>{
        const Cookie = require('js-cookie');
        if(Cookie)
        {
            if(Cookie.get('auth._token.local'))
            fetch(app.store.state.api_server+'logout', {
                headers:{
                    "Content-Type"  : "application/json",
                    "Accept"        : "application/json",
                    "Authorization" : Cookie.get('auth._token.local'),
                },
                method: "POST",
            });
            //
            Cookie.remove('auth._token.local');
            Cookie.remove('auth.strategy');
            Cookie.remove('auth._token_expiration.local');
            Cookie.remove('lockUser');
            window.localStorage.clear();
            window.location.href = window.location.origin+"/auth/login";
            //
            return 1;
        }
    });

    inject('paginatedIndex', (per_page, current_page, current_index) => {
        return ((per_page * current_page)-per_page) + current_index;
    });

    // CHECK ACTION MENUS, IS PERMITTED
    inject('ck_action', (uri, condition='or') => 
    {
        var actions = (app.store.state.action_paths) ? (app.store.state.action_paths) : [];
        //
        if(typeof uri == 'object'){
            var res = (condition=='or'?false:true), available=false;
            //
            Object.values(uri).filter(path=>{
                available = actions.includes(path);
                if(condition=='or' && available==true) res = true;
                else if(condition=='and' && available==false && res==true) res = false;
            });
            return res;
        }
        return (actions.indexOf(uri) > -1);
    });


    // CHECK ACTION MENUS, IS PERMITTED
    inject('ckMenu', (uri, condition='or') => 
    {
        var actions = (app.store.state.menu_paths) ? (app.store.state.menu_paths) : [];
        //
        if(typeof uri == 'object'){
            var res = (condition=='or'?false:true), available=false;
            //
            Object.values(uri).filter(path=>{
                available = actions.includes(path);
                if(condition=='or' && available==true) res = true;
                else if(condition=='and' && available==false && res==true) res = false;
            });
            return res;
        }
        return actions.includes(uri);
    });

    // MAKE ALERT
    inject('alert', (configaration) => {
        /*/ ICON LIST
         * *********************
         *  success,
         *  warning,
         *  info,
         *  error,
         *  question,
         * *********************
         * title: 'Are you sure?',
         * text: "You won't be able to revert this!"
         * icon: 'warning',
         * confirmButtonText: 'Yes, delete it!',
         * cancelButtonText: 'No, cancel!',
         * reverseButtons: true,
         * showCancelButton: true,
        /*/
        return Swal.fire(configaration);
    });


    // MAKE ALERT OBJECT
    inject('swal', (configaration) => {
        /*/ ICON LIST
         * *********************
         *  success,
         *  warning,
         *  info,
         *  error,
         *  question,
         * *********************
         * title: 'Are you sure?',
         * text: "You won't be able to revert this!"
         * icon: 'warning',
         * confirmButtonText: 'Yes, delete it!',
         * cancelButtonText: 'No, cancel!',
         * reverseButtons: true,
         * showCancelButton: true,
        /*/
        return Swal;
    });


    // MAKE ALERT OBJECT
    inject('shift', (shift) => {
        return (shift== 'morning' ? 'সকাল' : (shift== 'evening' ? 'বিকেল' : ''));
    });

    // Current Date
    inject('date', (format=null) => {
        var date = new Date();
        return (date.getFullYear()+'-'+(date.getMonth() > 8 ? (date.getMonth() + 1) : '0' + (date.getMonth() + 1))+'-'+(date.getDate() > 9 ? date.getDate() : '0'+date.getDate()));
    });

    // Current Date
    inject('currentShift', () => {
        var current_hours = (new Date()).getHours();
        return (current_hours > 12 ? 'evening' : 'morning');
    });

    //
    inject('locationSanitize', (obj=null)=>{
        if(obj){
            let address = [];
            Object.values(obj).forEach((area)=>{
                if(area.name)
                    address.push(area.name.bn);
            });
            return (address).join(', ');
        }
    });

    //
    inject('toFixed', (number=null)=>{
        if(number){
            return Number.parseFloat(number).toFixed(2);
        }
    });

    // MAKE ALERT OBJECT
    inject('msgSanitize', (obj) => {
        var message = '';
        if(obj && (typeof obj === 'object' || Array.isArray(obj))){
            Object.values(obj).forEach((value, index)=>{
                message += `<span>${value}</span><br>`;
            });
        }
        return (message ? message : obj);
    });

    //
    inject('local', (niddle='bn.bind')=>{
        var locals = {
            bn : {
                shop:'শপ',
                distributor:'শপ',
                van_driver:'ভ্যান চালক',
                pending:'অপেক্ষমান',
                rejected:'প্রত্যাখ্যাত',
                approved:'অনুমোদিত',
                bind : {
                    weekdayHeaderFormat: 'narrow',
                    labelPrevYear: 'গত বছর',
                    labelPrevMonth: 'পূর্ববর্তী মাস',
                    labelCurrentMonth: 'বর্তমান মাস',
                    labelNextMonth: 'পরের মাস',
                    labelNextYear: 'আগামী বছর',
                    labelNextDecade: 'পরবর্তী দশক',
                    labelPrevDecade: 'আগের দশক',
                    labelToday: 'আজ',
                    labelSelected: 'নির্বাচিত',
                    labelNoDateSelected: 'কোন তারিখ নির্বাচন করা হয়নি',
                    labelCalendar: 'ক্যালেন্ডার',
                    labelNav: '',
                    labelHelp: ''
                },
            }, 
            en : {
                shop:'Shop',
                distributor:'Distributor',
                van_driver:'Van Driver',
                pending:'Pending',
                rejected:'Rejected',
                approved:'Approved',
                bind : {
                    weekdayHeaderFormat: 'narrow',
                    labelPrevYear: 'গত বছর',
                    labelPrevMonth: 'পূর্ববর্তী মাস',
                    labelCurrentMonth: 'বর্তমান মাস',
                    labelNextMonth: 'পরের মাস',
                    labelNextYear: 'আগামী বছর',
                    labelNextDecade: 'পরবর্তী দশক',
                    labelPrevDecade: 'আগের দশক',
                    labelToday: 'আজ',
                    labelSelected: 'নির্বাচিত',
                    labelNoDateSelected: 'কোন তারিখ নির্বাচন করা হয়নি',
                    labelCalendar: 'ক্যালেন্ডার',
                    labelNav: '',
                    labelHelp: ''
                },
            }
        } 
        //
        niddle = niddle.split('.');
        if(niddle.indexOf('bn')==0 || niddle.indexOf('en')==0){
            niddle = niddle.slice(1);
        }
        //
        let result = locals[app.store.state.local];
        (niddle).forEach((value, key)=>{ 
            result = result[value];
        }); 
        //
        return (result ? result : niddle);
    });

    //
    inject('dashboardElement', (niddle='', module='') => {
        
        var dashboard_info_box = {}, dashboard_module = {}, menus = [], authorized = false;
        //
        (app.store.state.menus).filter(row=>{
            if(row.slug=='dashboard-module' && row.url=='/'){
                dashboard_module = row;
                menus = [...menus, ...row.action_menu];
            }
            else if(row.slug=='dashboard-card' && row.url=='/'){
                dashboard_info_box = row;
                menus = [...menus, ...row.action_menu];
            };
        });

        //
        if(niddle=='' && module=='module') return Object.values(dashboard_module.action_menu  ? dashboard_module.action_menu : []).length;
        if(niddle=='' && module=='info-box') return Object.values(dashboard_info_box.action_menu ? dashboard_info_box.action_menu : []).length;
        if(niddle=='actions' && module=='info-box') return (dashboard_info_box.action_menu ? dashboard_info_box.action_menu : []);
        else if(niddle=='') return Object.values(menus).length;
        else Object.values(menus).filter(row=>{(niddle==(module=='info-box'?row.slug:row.url)?authorized=true:'')}); return authorized;
    });

    //
    inject('setTimeToTag', (selector='') => {
        function setTime(){
            let timeTag = document.querySelector(selector);
            let date = new Date();
            let hh = date.getHours();
            let mm = date.getMinutes();
            let ss = date.getSeconds();
            let session = "AM";

            if (hh == 0) {
                hh = 12;
            }
            if (hh > 12) {
                hh = hh - 12;
                session = "PM";
            }

            hh = hh < 10 ? "0" + hh : hh;
            mm = mm < 10 ? "0" + mm : mm;
            ss = ss < 10 ? "0" + ss : ss;

            let time = hh + ":" + mm + ":" + ss + " " + session;
            
            if(timeTag)timeTag.innerText = time;
        }

        if(selector){
            setTime();
            setInterval(function () {
                setTime();
            }, 1000)
        }
    });

    inject('freshUri', (string='')=>{
        if((string).charAt((string).length - 1)=='/'){
            string = (string).slice(0, -1);
        }
        return string;
    });
}

