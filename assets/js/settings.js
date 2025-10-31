$(document).ready(function(){
    /* Check cookies */
        /*fixed*/
        var tFixed = $.cookies.get('themeSettings_fixed');
        if(null != tFixed){
            $(".wrapper").addClass('fixed');
            $(".settings input[name=settings_fixed]").attr('checked',true).parent('span').addClass('checked');
        }
        
        /*menu*/
        var tMenu = $.cookies.get('themeSettings_menu');
        if(null != tMenu){
            if(null != tMenu){                            
                $(".menu").addClass('hidden').hide();
                $(".header_menu li.list_icon").show();
                $(".content").addClass('wide');      
                $(".settings input[name=settings_menu]").attr('checked',true).parent('span').addClass('checked');
            }
        }
        /*bg*/
        var tBg = $.cookies.get('themeSettings_bg');
        if(null != tBg){
            $('body').removeAttr('class').addClass(tBg);
            $('.settings .bgExample').removeClass('active');
            $('.settings .bgExample[data-style="'+tBg+'"]').addClass('active');
        }
        /*theme style*/
        var tStyle = $.cookies.get('themeSettings_style');
        if(null != tStyle){
            if($('.wrapper').hasClass('fixed'))
                $(".wrapper").attr('class','').addClass('wrapper fixed');
            else
                $(".wrapper").attr('class','').addClass('wrapper');            
            
            $('.settings .styleExample').removeClass('active');
            $(".wrapper").addClass(tStyle);        
            $('.settings .styleExample[data-style="'+tStyle+'"]').addClass('active');
        }        
    
    /* Check cookies */
    
    $(".link_themeSettings").click(function(){
        
        if($("#themeSettings").is(':visible')){
            $("#themeSettings").fadeOut(200);
            $("#themeSettings").find(".checker").hide();
        }else{
            $("#themeSettings").fadeIn(300);        
            $("#themeSettings").find(".checker").show();
        }
        
       return false;
       
    });
    
    $(".settings input[name=settings_fixed]").change(function(){
        if($(this).is(':checked')){
            $(".wrapper").addClass('fixed');
             $.cookies.set('themeSettings_fixed','1');
        }else{
            $(".wrapper").removeClass('fixed');
            $.cookies.set('themeSettings_fixed',null);
        }
    });
    
    $(".settings input[name=settings_menu]").change(function(){
        
        if($(this).is(':checked')){
            $(".menu").addClass('hidden').hide();
            $(".header_menu li.list_icon").show();
            $(".content").addClass('wide');
            $.cookies.set('themeSettings_menu','1');
        }else{
            $(".menu").removeClass('hidden').removeAttr('style');
            $(".header_menu li.list_icon").hide();
            $(".content").removeClass('wide');
            $("body > .modal-backdrop").remove();
            $.cookies.set('themeSettings_menu',null);
        }
        
    });    
    
    $(".settings .bgExample").click(function(){
        var cls = $(this).attr('data-style');        
        
        $('body').removeAttr('class');
        $('.settings .bgExample').removeClass('active');
        
        if(cls != ''){
            $('body').addClass(cls);
            $(this).addClass('active');
            $.cookies.set('themeSettings_bg',cls);
        }else{
            $(this).addClass('active');
            $.cookies.set('themeSettings_bg',null);
        }
        return false;
    });

    $(".settings .styleExample").click(function(){
        var cls = $(this).attr('data-style');
        var theme = $(this).attr('data-theme');
        
        if($('.wrapper').hasClass('fixed'))
            $(".wrapper").attr('class','').addClass('wrapper fixed');
        else
            $(".wrapper").attr('class','').addClass('wrapper');
                        
        $('.settings .styleExample').removeClass('active');
        
        // Remover todos los temas profesionales del body
        $('body').removeClass('theme-default theme-dark-pro theme-ocean-blue theme-purple-dream theme-emerald-green theme-sunset-orange');
        
        if(cls != ''){
            $(".wrapper").addClass(cls);
            // Si tiene data-theme, aplicarlo al body también
            if(theme) {
                $('body').addClass('theme-' + theme);
                $.cookies.set('themeSettings_bodyTheme', theme);
            } else {
                $.cookies.set('themeSettings_bodyTheme', null);
            }
            $(this).addClass('active');
            $.cookies.set('themeSettings_style',cls);
        }else{
            $(this).addClass('active');
            $.cookies.set('themeSettings_style',null);
            $.cookies.set('themeSettings_bodyTheme',null);
        }
    
        return false;
    });
    
    // Cargar tema del body desde cookies al iniciar
    var tBodyTheme = $.cookies.get('themeSettings_bodyTheme');
    if(null != tBodyTheme){
        $('body').addClass('theme-' + tBodyTheme);
    }
    
});