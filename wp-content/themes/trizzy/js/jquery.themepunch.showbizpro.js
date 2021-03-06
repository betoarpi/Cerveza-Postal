

/***************************************************************************************
 * jQuery.themepunch.ShowBiz Pro.js - jQuery Plugin for ShowBiz Pro Teaser Rotator
 * @version: 1.7.1 (19.08.2014)
 * @requires jQuery v1.7 or later
 * @author ThemePunch
****************************************************************************************/



(function(jQuery,undefined){


	////////////////////////////////////////
	// THE REVOLUTION PLUGIN STARTS HERE //
	///////////////////////////////////////

	jQuery.fn.extend({

		///////////////////////////
		// MAIN PLUGIN  FUNCTION //
		///////////////////////////
		showbizpro: function(options) {

				jQuery.fn.showbizpro.defaults = {
					entrySizeOffset:0,
					containerOffsetRight:0,
					heightOffsetBottom:0,
					carousel:"off",
					visibleElementsArray:[4,3,2,1],
					mediaMaxHeight:[0,0,0,0],
					ytMarkup:"<iframe src='http://www.youtube.com/embed/%%videoid%%?hd=1&amp;wmode=opaque&amp;autohide=1&amp;showinfo=0&amp;autoplay=1'></iframe>",
					vimeoMarkup:"<iframe src='http://player.vimeo.com/video/%%videoid%%?title=0&amp;byline=0&amp;portrait=0;api=1&amp;autoplay=1'></iframe>",
					closeOtherOverlays:"off",
					allEntryAtOnce:"off",
					dragAndScroll:"off",
					autoPlay:"off",
					delay:3000,
					speed:300,
					rewindFromEnd:"off",
					easing:"punchgs.Power3.easeOut",
					forceFullWidth:false,
					scrollOrientation:"left"


				};

				options = jQuery.extend({}, jQuery.fn.showbizpro.defaults, options);


				return this.each(function() {



					var container=jQuery(this);

					// REPORT SOME IMPORTAN INFORMATION ABOUT THE SLIDER						
					console.groupCollapsed("ShowBiz 1.7 Initialisation on "+container.attr('id'));						
					console.groupCollapsed("Used Options:");
					console.info(options);
					console.groupEnd();
					console.groupCollapsed("Tween Engine:")
					
					// CHECK IF TweenLite IS LOADED AT ALL
					if (punchgs.TweenLite==undefined) {
					    console.error("GreenSock Engine Does not Exist!");
						return false;
					}
					
					punchgs.force3D = true;

					console.info("GreenSock Engine Version in ShowBiz:"+punchgs.TweenLite.version);

					punchgs.TweenLite.lagSmoothing(1000, 16);
					punchgs.force3D = "auto";
						
						
					console.groupEnd();
					console.groupEnd();
					
					
					if (options.forceFullWidth==true) {

							var loff = container.offset().left;
							var mb = container.css('marginBottom');
							var mt = container.css('marginTop');
							if (mb==undefined) mb=0;
							if (mt==undefined) mt=0;

							container.wrap('<div style="position:relative;width:100%;height:auto;margin-top:'+mt+';margin-bottom:'+mb+'" class="forcefullwidth_wrapper_tp_banner"></div>');
							container.closest('.forcefullwidth_wrapper_tp_banner').append('<div class="tp-fullwidth-forcer" style="width:100%;height:'+container.height()+'px"></div>');
							container.css({'maxWidth':'none','left':(0-loff)+"px",position:'absolute','width':jQuery(window).width()});

						}


					// SAVE THE DEFAULT OPTIONS
					container.data('eoffset',options.entrySizeOffset);
					container.data('croffset',options.containerOffsetRight);
					container.data('hboffset',options.heightOffsetBottom);

					container.data('ease',options.easing);
					if (options.carousel=="on")
						container.data('carousel',1)
					else
						container.data('carousel',0);

					container.data('ytmarkup',options.ytMarkup);
					container.data('vimeomarkup',options.vimeoMarkup);
					container.data('vea',options.visibleElementsArray);
					container.data('coo',options.closeOtherOverlays);
					container.data('allentry',options.allEntryAtOnce);
					container.data('mediaMaxHeight',options.mediaMaxHeight);
					container.data('das',options.dragAndScroll);
					container.data('rewindfromend',options.rewindFromEnd);
					container.data('forceFullWidth',options.forceFullWidth)
					container.data('scrollOrientation',options.scrollOrientation)


					container.data('currentoffset',0)

					options.speed = parseInt(options.speed,0);
					options.delay = parseInt(options.delay,0);

					container.data('speedy',options.speed);
					container.data('ie',!jQuery.support.opacity);
					container.data('ie9',(document.documentMode == 9));

					// CHECK THE jQUERY VERSION
					var version = jQuery.fn.jquery.split('.'),
						versionTop = parseFloat(version[0]),
						versionMinor = parseFloat(version[1]),
						versionIncrement = parseFloat(version[2] || '0');

					if (versionTop>1) container.data('ie',false);


					// CLONE IF CAROUSEL IS SELECTED, AND ITEM AMOUNT IS NOT ENOUGH
					if (options.carousel=="on") {
						if (container.find('ul').first().find('>li').length<17) {
							container.find('ul').first().find('>li').each(function(i) {
								jQuery(this).clone(true).appendTo(container.find('ul').first())
							});
						}
						if (container.find('ul').first().find('>li').length<17) {
							container.find('ul').first().find('>li').each(function(i) {
								jQuery(this).clone(true).appendTo(container.find('ul').first())
							});
						}
					}


					var tr = container.find('.showbiz');
					tr.attr('id',"sbiz"+Math.round(Math.random()*10000));



					var driftTimer;


					// IF DRAG AND SCROLL FUNCTION IS ACTIVATED....
					tr.find('img').on('dragstart', function(event) { event.preventDefault(); });
					try{
							if (options.dragAndScroll=="on") {
								var ul = tr.find('.overflowholder ul');												
								tr.swipe({
									allowPageScroll:"vertical",
									swipeStatus:function(event,phase,direction,distance,duration,fingerCount) {
											ul.addClass("dragged");
											var newpos = ul.data('newpos');									
											if (newpos == undefined) {
												newpos = ul.position().left;
												ul.data("newpos",newpos);
											}
		
										switch (direction) {
											case "right":
												if (newpos>0) newpos = 0;
													punchgs.TweenLite.to(ul,0.1,{left:newpos+distance, ease:punchgs.Power3.easeOut});
													
											break;
											case "left":
												if (newpos>0) newpos = 0;
													punchgs.TweenLite.to(ul,0.1,{left:newpos-distance, ease:punchgs.Power3.easeOut});
											break;
																				
										}
									},
									swipe: function(event,direction,distance,duration,fingerCount) {
										ul.data("newpos",ul.position().left);
										ul.removeClass("dragged");
										scrollOver(container,0);
									}							
								})
		
								ul.addClass("showbiz-drag-mouse");
		
		
		
							}
					} catch(e) {}

					//PREPARE NAVIGATION IF NOT EXIST !
					var rndid = Math.round(Math.random()*100000);

					if (tr.data('left')==undefined) tr.data('left','sb_left_'+rndid);
					if (tr.data('right')==undefined) tr.data('right','sb_right_'+rndid);
					if (tr.data('play')==undefined) tr.data('play','sb_play_'+rndid);

					var lb = jQuery(tr.data('left'));
					var rb = jQuery(tr.data('right'));
					var pb = jQuery(tr.data('play'));


					if (lb==undefined || lb.length==0)
						jQuery('body').append('<a style="display:none" id="'+tr.data('left')+'" class="sb-navigation-left"><i class="sb-icon-left-open"></i></a>');
					if (rb==undefined || rb.length==0)
						jQuery('body').append('<a style="display:none" id="'+tr.data('right')+'" class="sb-navigation-right"><i class="sb-icon-right-open"></i></a>');
					if (pb==undefined || pb.length==0)
						jQuery('body').append('<a style="display:none" id="'+tr.data('play')+'" class="sb-navigation-play"><i class="sb-icon-play sb-playbutton"></i><i class="sb-icon-pause sb-pausebutton"></i></a>');


					initTeaserRotator(container,tr);

					function goInterval() {
						container.data('timer',setInterval(function() {
							if (container.width()>0) {
								if (container.data('scrollOrientation')=="right") {
									var rb = jQuery(container.find('.showbiz').data('left'));
									if (!container.hasClass("hovered")) lbclick(container,rb,true);
								} else {
									var rb = jQuery(container.find('.showbiz').data('right'));
									if (!container.hasClass("hovered")) rbclick(container,rb,true);
								}
							}
						},options.delay));
					}

					function stopInterval() {
					    clearInterval(container.data('timer'));
					}

					// TURN ON / OFF AUTO PLAY
					if (options.autoPlay!="on")  {
						jQuery(container.find('.showbiz').data('play')).remove();
					} else {

						// STart THE AUTOPLAY
						goInterval();

						// COLLECT THE PLAYBUTTON
						var pb = jQuery(container.find('.showbiz').data('play'));

						// HIDE THE PLAY BUTTON NOW
						pb.find('.sb-playbutton').addClass("sb-hidden");

						container.hover(function() {
								container.addClass("hovered")
							},
							function() {
								container.removeClass("hovered")
							});
						pb.click(function() {
							if (pb.hasClass("paused")) {
								goInterval();
								pb.removeClass("paused");
								pb.find('.sb-pausebutton').removeClass("sb-hidden");
								pb.find('.sb-playbutton').addClass("sb-hidden");
							} else {
								stopInterval();
								pb.addClass("paused");
								pb.find('.sb-pausebutton').addClass("sb-hidden");
								pb.find('.sb-playbutton').removeClass("sb-hidden");
							}
						});

					}



					// INIT THE REVEAL FUNCTIONS
					initRevealContainer(container,tr);

					// FIT VIDEO SIZES IN DIFFERENT COTAINERS
					try {
						container.find('.mediaholder_innerwrap').each(function() {
							var mw=jQuery(this);
							if (mw.find('iframe').length>0)
								jQuery(this).fitVids();
						});
					} catch(e) {}

					// SOME HOVER EFFECTS
					initHoverAnimations(container);

					/****************************************************
						-	APPLE IPAD AND IPHONE WORKAROUNDS HERE	-
					******************************************************/

					if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
					    jQuery(".reveal_opener, .sb-navigation-left, .sb-navigation-right").click(function(){
					        //we just need to attach a click event listener to provoke iPhone/iPod/iPad's hover event
					        //strange
					    });
					}
				})

			},

		///////////////////////
		// METHODE RESUME    //
		//////////////////////
		showbizredraw: function(option) {
				return this.each(function() {
					// CATCH THE CONTAINER
					var container=jQuery(this);
					var tr = container.find('.showbiz');
					rebuildTeasers(200,container,tr);
				})
		}


	})


		//////////////////
		// IS MOBILE ?? //
		//////////////////
		function is_mobile() {
		    var agents = ['android', 'webos', 'iphone', 'ipad', 'blackberry','Android', 'webos', ,'iPod', 'iPhone', 'iPad', 'Blackberry', 'BlackBerry'];
			var ismobile=false;



		    for(i in agents) {

			    if (navigator.userAgent.split(agents[i]).length>1)
		            ismobile = true;

		    }
		    return ismobile;
		}

		////////////////////////////
		// INIT HOVER ANINATIONS //
		////////////////////////////
		function initHoverAnimations(container) {

			container.find('.show_on_hover, .hovercover').each(function() {

				var li=jQuery(this).closest('li');

				punchgs.TweenLite.to(jQuery(this),0.2,{opacity:0,overwrite:"all",ease:punchgs.Power3.easeInOut});

				li.hover(function() {

					jQuery(this).find('.show_on_hover, .hovercover').each(function() {
						var maxop=1;
						if (jQuery(this).data('maxopacity')!=undefined) maxop=jQuery(this).data('maxopacity');

						punchgs.TweenLite.to(jQuery(this),0.2,{opacity:maxop,overwrite:"all",ease:punchgs.Power3.easeInOut});

					})
				},
				function() {
					jQuery(this).find('.show_on_hover, .hovercover').each(function() {
						punchgs.TweenLite.to(jQuery(this),0.2,{opacity:0,ease:punchgs.Power3.easeInOut});
					})

				});
			})
		}



		////////////////////////////
		// INIT REVEAL ITEMS HERE //
		////////////////////////////
		function initRevealContainer(container,tr) {

		    container.find('.excerpt').each(function() {
			    var ex=jQuery(this);
			    ex.closest('li').hover(function() {

				    ex.slideDown(300);
			    },
			    function() {
			    	ex.stop(true);
				    ex.slideUp(300);
			    })
		    })

		    container.find('.closeme.inside').click(function() {
			    var rop = container.find('.reveal_container.revactive');
			    if (rop.hasClass("revactive")) {

						container.find('.revactive').removeClass("revactive");
						punchgs.TweenLite.fromTo(rop.find('.reveal_wrapper'),0.3,{visibility:"visible",top:"0%",height:"100%",opacity:1},{opacity:0,top:"0%",height:"0%",ease:punchgs.Power3.easeInOut});


						// REMOVE THE VIDEO CONTAINER CONTENTS
						rop.find('.sb-vimeo-markup, .sb-yt-markup').html("");

						if (rop.hasClass('tofullwidth')) {
							rebuildTeasers(200,container,tr);
							setTimeout(function() {
								rop.appendTo(rop.data('comefrom'));
							},350);
						}
					}
		    })
			container.find('.reveal_opener').each(function() {
				var ro=jQuery(this);
				ro.click(function() {

					// IDENTIFICATE WHERE THE REVEAL CONTAINER IS
					if (ro.parent().hasClass('reveal_container'))
						var rop = ro.parent();
					else
						var rop = ro.parent().find('.reveal_container');

					// CHECK IF OVERLAY OPEN OR CLOSED
					if (rop.hasClass("revactive")) {

						// IF OPENED THEN LET IT CLOSE
						//setTimeout(function() {
							rop.removeClass("revactive");
							ro.removeClass("revactive");
						//},310);



						rop.closest('li').removeClass("revactive");
						punchgs.TweenLite.fromTo(rop.find('.reveal_wrapper'),0.3,{visibility:"visible",top:"0%",height:"100%",opacity:1},{opacity:0,top:"0%",height:"0%",ease:punchgs.Power3.easeInOut});


						// REMOVE THE VIDEO CONTAINER CONTENTS
						rop.find('.sb-vimeo-markup, .sb-yt-markup').html("");

						if (rop.hasClass('tofullwidth')) {
							rebuildTeasers(200,container,tr);
							setTimeout(function() {
								rop.appendTo(rop.data('comefrom'));
							},350);
						}
					} else {

						// IF IT IS CLOSED, THEN WE NEED TO OPEN IT
						if (rop.hasClass('tofullwidth')) {

							rop.data('comefrom',rop.parent());
							rop.data('indexli',rop.closest('li').index());
							rop.appendTo(rop.closest('.showbiz'));
							ro.addClass("revactive");
						}


						setTimeout(function() {
							// CLOSE ALL OTHER OPENED OVERLAYS
							if (container.data('coo') == "on")
								rop.closest('ul').find('.reveal_opener').each(function(i) {
									if (jQuery(this).hasClass("revactive")) jQuery(this).click();
								})

							rop.addClass("revactive");
							ro.addClass("revactive");
							rop.closest('li').addClass("revactive");
							punchgs.TweenLite.fromTo(rop.find('.reveal_wrapper'),0.3,{visibility:"visible",height:"0%",top:"0%",opacity:0},{visibility:"visible",top:"0%",height:"100%",opacity:1,ease:punchgs.Power3.easeInOut});


							// AUTO EMBED VIMEO AND YOUTUBE VIDEOS ON DEMAND
							rop.find('.sb-vimeo-markup, .sb-yt-markup').each(function(i) {
								var video = jQuery(this);

								if (video.hasClass("sb-vimeo-markup"))
									var basic = container.data('vimeomarkup');
								else
									var basic = container.data('ytmarkup');


								var vbe=basic.split('%%videoid%%')[0];
								var vaf=basic.split('%%videoid%%')[1];

								var basic= vbe+video.data('videoid')+vaf;


								video.append(basic);

								try{ video.fitVids(); } catch(e) { }
							});


							setTimeout(function() {setRevContHeight(container,tr);},500);
						},100);
					}
				});
			});
		}


		//////////////////////////////////////////////////
		// CALCULATE THE HEIGHT OF THE REVEAL CONTAINER //
		//////////////////////////////////////////////////
		function setRevContHeight(container,tr) {
			var revc=container.find('.tofullwidth.revactive .heightadjuster');

			var ul = tr.find('ul').first();
			var dif = parseInt(revc.parent().css('paddingTop'),0) + parseInt(revc.parent().css('paddingBottom'),0);

			var hbo=0;
			if (container.data('hboffset')!=undefined) hbo=container.data('hboffset');

			var nh = hbo + dif +revc.outerHeight(true);

			punchgs.TweenLite.to(ul,0.3,{height:nh+"px",ease:punchgs.Power3.easeInOut});
			punchgs.TweenLite.to(ul.parent(),0.3,{height:nh+"px",ease:punchgs.Power3.easeInOut});
			var navheight = container.find('.showbiz-navigation').outerHeight(true);

			punchgs.TweenLite.to(container.closest('.forcefullwidth_wrapper_tp_banner'),0.3,{height:(nh+navheight)+"px",ease:punchgs.Power3.easeInOut});
		}





		////////////////////////
		// LEFT BUTTON CLICK //
		///////////////////////
		function lbclick(container, lb,autoplayed) {



				var car= container.data('carousel');
				var speedy = container.data('speedy');
				// IF FULLWIDTH REVACTIVE IS ALREADY ON
				if (container.find('.tofullwidth.revactive .heightadjuster').length>0) {
					var activerev_index=container.find('.tofullwidth.revactive').data('indexli');
					var newindex=activerev_index;
					if (newindex<=0) newindex=container.find('ul:first-child li').length;
					container.find('.tofullwidth.revactive').addClass("sb-removemesoon");
					setTimeout(function() {
						container.find('.tofullwidth.revactive.sb-removemesoon .reveal_opener').click();
						container.find('.sb-removemesoon').each(function() {jQuery(this).removeClass('sb-removemesoon');});
					},350);

					container.find('ul:first-child li:nth-child('+newindex+')').find('.reveal_opener').click();

				}  else {

							var tr=lb.data('teaser');
							var ul = tr.find('ul').first();

							if (container.data('das') == "on") {
								scrollOver(container,1,autoplayed);
							} else {
									var off = container.data('currentoffset');
									var moveit;
									var di=container.width();
									if (container.data('allentry')=="on") {
										if (di>980)  { moveit=container.data('vea')[0]; }
										if (di<981 && di>768)  { moveit=container.data('vea')[1];}
										if (di<769 && di>420)  { moveit=container.data('vea')[2]; }
										if (di<421)  { moveit=container.data('vea')[3]; }
									} else {
										moveit = 1;
									}
 
									if ( maxitem>=moveit)
										off = off - moveit;
									else
										off = 0;
									container.data('currentoffset',off);

									rebuildTeasers(speedy,container,tr);
							}
				}





		}

		////////////////////////
		// RIGHT BUTTON CLICK //
		///////////////////////
		function rbclick(container,rb,autoplayed) {

				var car= container.data('carousel');
				var speedy = container.data('speedy');


				// IF FULLWIDTH REVACTIVE IS ALREADY ON
				if (container.find('.tofullwidth.revactive .heightadjuster').length>0) {

					var activerev_index=container.find('.tofullwidth.revactive').data('indexli');
					var newindex=activerev_index+2;
					if (newindex>container.find('ul:first-child li').length) newindex=1;
					container.find('.tofullwidth.revactive').addClass("sb-removemesoon");
					setTimeout(function() {
						container.find('.tofullwidth.revactive.sb-removemesoon .reveal_opener').click();
						container.find('.sb-removemesoon').each(function() {jQuery(this).removeClass('sb-removemesoon');});
					},350);

					container.find('ul:first-child li:nth-child('+newindex+')').find('.reveal_opener').click();


				} else {


							var tr=jQuery(rb.data('teaser'));
							var ul = tr.find('ul').first();
							var maxitem=ul.find('>li').length;

							// IF DRAG AND SCROLL FUNCTION ACTIVATED
							if (container.data('das') == "on") {
								scrollOver(container,-1,autoplayed);

							} else {

									var off = container.data('currentoffset');
									var moveit;
									var di=container.width();
									if (container.data('allentry')=="on") {
										if (di>980)  { moveit=container.data('vea')[0]; }
										if (di<981 && di>768)  { moveit=container.data('vea')[1];}
										if (di<769 && di>420)  { moveit=container.data('vea')[2]; }
										if (di<421)  { moveit=container.data('vea')[3]; }
									} else {
										moveit = 1;
									}


									if ( maxitem>=moveit)
										off = off + moveit;
									else
										off = 0;
									container.data('currentoffset',off);
									rebuildTeasers(speedy,container,tr);


							}


				 }


		}

		/**********************************
			-	LAZY LOADER / PRELOADER	-
		***********************************/

		function lazyLoader(container) {
			var togo=0;

			container.find('img').each(function() {
					var img = jQuery(this);
					var newsrc = img.data('lazyloadsrc')

					if (newsrc !=undefined && newsrc.length>3 && !img.hasClass("waitingforload") && togo<4) {
							img.addClass("waitingforload");
							img.closest('.mediaholder').append('<div class="sb-preloader"></div>');

							var nc=img;

						    if (nc.data('wan') == undefined) nc.data('wan',nc.css("-webkit-transition"));
							if (nc.data('moan') == undefined) nc.data('moan',nc.css("-moz-animation-transition"));
							if (nc.data('man') == undefined) nc.data('man',nc.css("-ms-animation-transition"));
							if (nc.data('ani') == undefined) nc.data('ani',nc.css("transition"));


						    nc.css("-webkit-transition", "none");
						    nc.css("-moz-transition", "none");
						    nc.css("-ms-transition", "none");
						    nc.css("transition", "none");

						    var limg = new Image();
						    limg.onload = function() {
							    img.attr('src',newsrc);
							    punchgs.TweenLite.set(img,{height:"auto",overwrite:"auto"});
							    punchgs.TweenLite.fromTo(img,0.2,{autoAlpha:0},{autoAlpha:1,overwrite:"auto"});
							    img.removeClass("waitingforload");
							    punchgs.TweenLite.to(img.closest('.mediaholder').find('.sb-preloader'),0.3,{autoAlpha:0,onComplete:function() {
								    img.closest('.mediaholder').find('.sb-preloader').remove();
							    }});

							    setTimeout(function() {
									nc.css("-webkit-transition", nc.data('wan'));
								    nc.css("-moz-transition", nc.data('moan'));
								    nc.css("-ms-transition", nc.data('man'));
								    nc.css("transition", nc.data('ani'));

								},300);
						    };
						    limg.src = newsrc;
							img.data('lazyloadsrc','');
							togo++;
					 } else {
					    if (img.hasClass("waitingforload")) togo++;
					    if (newsrc !=undefined && newsrc.length>3) {
						    if (img.data('lazyloadheight') != undefined) img.css({height:parseInt(img.data('lazyloadheight'),0)});
					    }

					 }
				})

			if (togo!=0)
				setTimeout(function() {
					lazyLoader(container)
				},50)
			else
				jQuery('body').trigger('resize');



		}

		///////////////////////////////////////
		// FUNCTION HOVER ON SQUARE ELEMENTS //
		///////////////////////////////////////
		function initTeaserRotator(container,tr) {

			var car= container.data('carousel');

			/** THE RATING STARS SHOULD BE SHOWN AS STARTS **/
			container.find('.rating-star').each(function() {
				var wcr=jQuery(this);
				if (wcr.data('rates')!=undefined) {
					var rated=wcr.data('rates');
					wcr.append('<div class="sb-rateholder"></div>');
					for (var i=1;i<6;i++) {
						var wwi=100;
					 if (rated==0) {
						 wwi=0;
					 } else {
						if (rated>=i)
						    wwi=100;
						else {
						   wwi = (rated - Math.floor(rated)) * 100;
						   if ((i-rated)>1) wwi=0;

						 }
					}
						wcr.find('.sb-rateholder').append('<div class="sb-rateholder-single"><div style="width:'+wwi+'%;overflow:hidden"><i class="sb-icon-star"></i></div><i class="sb-icon-star-empty"></i></div>');
					}
					wcr.find('.sb-rateholder').append('<div class="sb-clear"></div>');
				}
			});


			lazyLoader(container);

			var lb = jQuery(tr.data('left'));
			var rb = jQuery(tr.data('right'));

			var di = container.width();

			lb.data('teaser',tr);
			rb.data('teaser',tr);
			tr.data('offset',0);

			rebuildTeasers(0,container,tr);

			container.find('img').each(function() {
				jQuery(this).parent().waitForImages(function() {
					rebuildTeasers(200,container,tr);

				});
			})


			// THE RIGHT CLICK EVENT ON TEASER ROTATOR
			// THE LEFT CLICK EVENT ON TEASER ROTATOR
			rb.click(function() {
				rbclick(container,rb);
				 return false;
			});

			// THE LEFT CLICK EVENT ON TEASER ROTATOR
			lb.click(function() {
				lbclick(container,lb);
				return false;
			});


			if (container.data('das')!="on") {
				try{
					container.swipe({
						 allowPageScroll:"vertical",
						 swipe:function(event, direction, distance, duration, fingerCount) {
						 	switch (direction) {
							 	case "left":
							 		rb.click();
							 	break;
							 	case "right":
							 		lb.click();
							 	break;
						 	}
	
			   			}				
					});
				} catch(e) {}
			}




			var timeouts;



			// IF WINDOW IS RESIZED, TEASER SHOUL REPOSITION ITSELF
			jQuery(window).resize(function() {
				clearTimeout(timeouts);
				container.addClass("hovered")
				timeouts= setTimeout(function() {
					   if (container.data('forceFullWidth')==true) {

												var loff = container.closest('.forcefullwidth_wrapper_tp_banner').offset().left;
												//opt.container.parent().css({'width':jQuery(window).width()});
												container.css({'left':(0-loff)+"px",'width':jQuery(window).width()});
											}

					   rebuildTeasers(300,container,tr);
					   if (container.data('das')=="on") {
							setTimeout(function() { scrollOver(container,0); },300);
						}
						container.removeClass("hovered")
				},150);
			});


			for (var j=0;j<3;j++) {
				jQuery(window).data('teaserreset',setTimeout(function() {
					rebuildTeasers(200,container,tr);
				},j*500));
			}



		}


		///////////////////////////////////////////////////
		//	FUNCTION TO SCROLL DRAG & SCROLL IN POSITION //
		//////////////////////////////////////////////////
		function scrollOver(container,offset,autoplayed) {

				var tr=container;					// THE CONTAINER VARIABLE
				var di = container.width();			// WIDTH OF THE CONTAINER

				var ul = tr.find('ul').first();		// THE SCROLLED LIST

				var maxitem=ul.find('>li').length;	// THE AMOUNT OF THE LI ITEMS
				var visibleamount =4;				// CURRENT VISIBLE AMOUNTS

				// LETS CHECK HOW MANY ITEMS WE CAN SEE IN THE SAME TIME
				if (di>980)  visibleamount=container.data('vea')[0];
				if (di<981 && di>768) visibleamount=container.data('vea')[1];
				if (di<769 && di>420) visibleamount=container.data('vea')[2];
				if (di<421)  visibleamount=container.data('vea')[3];

				// WHICH IS THE LAST ITEM ON THE LEFT SITE AFTER THE SCROLL
				var lastlefitem = maxitem-visibleamount;

				// THE WIDTH OF THE LI'S
				var wid = ul.find('>li:first-child').outerWidth(true);


				var ofh = tr.find('.overflowholder')		//THE OVERFLOW HOLDER, THE CONTAINER PARENT FOR SCROLL
				var csp = ul.position().left;				// THE CURRENT SCROLL POSITION OF THIS CONTAINER
				var cip = Math.round(csp/wid);				// AT WHICH ITEM WE STAY ??

				var rb=jQuery(ofh.parent().data('right'));
				var lb=jQuery(ofh.parent().data('left'));


				var scrollto = (cip+offset)*wid;			// WHERE TO SCROLL


				if (Math.abs(scrollto)>=(lastlefitem*wid)) {

					scrollto = -(lastlefitem*wid);			// IF TO FAR WE NEED TO SCROLL BACK
					try{ rb.addClass('notclickable'); } catch(e) {}
					if (container.hasClass("sb-attheend")) {
						try{ rb.removeClass('notclickable'); } catch(e) {}
						container.removeClass("sb-attheend");
						scrollto=0;
					} else {
						if (autoplayed && tr.data("rewindfromend")=="on")
							container.addClass("sb-attheend");
					}

				} else {
					container.removeClass("sb-attheend");
					try{ rb.removeClass('notclickable'); } catch(e) {}
				}

				if (scrollto>=0) {
					scrollto = 0;							// IF TO FAR WE NEED TO SCROLL BACK
					try{ lb.addClass('notclickable'); } catch(e) {}
				} else {
					try{ lb.removeClass('notclickable'); } catch(e) {}
				}



				punchgs.TweenLite.to(ul,0.3,{left:scrollto});

		};



		/////////////////////////////////////////////////////
		// FUNCTION TO REPOSITION AND REBUILD THE TEASERS //
		////////////////////////////////////////////////////

		function rebuildTeasers(speed,container,tr) {



					var car= container.data('carousel');
					var ul = tr.find('ul');
					var off =container.data('currentoffset');
					var di = container.width();
					var padds = parseInt(tr.css('paddingLeft'),0) + parseInt(tr.css('paddingRight'),0);
					di=di-padds;

					if (ul.parents(':hidden').length!=0) return false;


					var ul = tr.find('ul:first');
					maxitem=ul.find('>li').length;
					var rb=jQuery(tr.data('right'));
					if (container.data('das')!="on") rb.removeClass('notclickable');

					var lb=jQuery(tr.data('left'));
					if (container.data('das')!="on")  lb.removeClass('notclickable');

					var visibleamount=container.data('vea')[0];
					var marray=container.data('mediaMaxHeight');

					if (di>980)  {
						visibleamount=container.data('vea')[0];

						try{
								if (marray[0] !=0)
								container.find('.mediaholder_innerwrap').each(function() {
											jQuery(this).css({'maxHeight':marray[0]+"px"});
								});
							} catch(e) {  }
					}
					if (di<981 && di>768)  {
						visibleamount=container.data('vea')[1];
						try{
								if (marray[1] !=0)
								container.find('.mediaholder_innerwrap').each(function() {
											jQuery(this).css({'maxHeight':marray[1]+"px"});
								});
							} catch(e) {  }
					}
					if (di<769 && di>420)  {
						visibleamount=container.data('vea')[2];
						try{
								if (marray[2] !=0)
								container.find('.mediaholder_innerwrap').each(function() {
											jQuery(this).css({'maxHeight':marray[2]+"px"});
								});
							} catch(e) {  }

					}
					if (di<421)  {
						visibleamount=container.data('vea')[3];
						try{
								if (marray[3] !=0)
								container.find('.mediaholder_innerwrap').each(function() {
											jQuery(this).css({'maxHeight':marray[3]+"px"});
								});
							} catch(e) {  }
					}


					var space = ul.find('>li:first-child').outerWidth(true) - ul.find('>li:first-child').width();
					var eo=0;
					if (container.data('eoffset')!=undefined) eo=container.data('eoffset') * (visibleamount-1);
					var cro=0;
					if (container.data('croffset')!=undefined) cro=container.data('croffset');
					step=(di-((visibleamount-1)*space)) / visibleamount;
					step=Math.round(step-eo);

					var newWidth = false;
					ul.find('>li').each(function() {
						if (jQuery(this).width() != step) newWidth = true;
						jQuery(this).width(step);

					});

					ul.css({'width':'40000px'});

					var mrDelay=0;
					if (newWidth) mrDelay = 450;

					var easeMe = container.data('ease');

					setTimeout(function() {

						step=ul.find('li:first').outerWidth(true);
						var stepxoff=(step*off);
						if (stepxoff<0) stepxoff =0;
						var mrdelay=0;
						var distance = (maxitem*step) - di;
						var lastpos = (stepxoff+space)

						if (car!=1) {

								// CHECK IF LAST ITEM HAS BEEN REACHED IF CAROUSEL NOT TURNED OFF
								if ((distance+3) <= lastpos && off>1) {

									if (container.data('rewindfromend')=="on") {

										if (distance < lastpos) {
											stepxoff=0;
											container.data('currentoffset',0);
										}
									} else {
										container.data('currentoffset',maxitem-visibleamount);
										stepxoff=(step*(maxitem-visibleamount));
										rb.addClass("notclickable");
									}
								}

								if (off<=0) {
									if (container.data('rewindfromend')=="on") {
										if (off<0) {
											container.data('currentoffset',maxitem-visibleamount);
											stepxoff=(step*(maxitem-visibleamount));
										}
									} else {
										stepxoff=0;
										container.data('currentoffset',0);
										lb.addClass("notclickable");
									}
								}
								if (isIE(8))
									punchgs.TweenLite.to(ul,speed/1000,{left:(0-stepxoff)+"px",transformPerspective:300,ease:easeMe});
								else
									punchgs.TweenLite.to(ul,speed/1000,{x:(0-stepxoff)+"px",transformPerspective:300,ease:easeMe});

						} else {
								if ((distance) <= lastpos) {
									off = off-2;

									container.data('currentoffset',off+1);
									stepxoff=(step*off);
									ul.find('>li').first().appendTo(ul);
									if (isIE(8))
										punchgs.TweenLite.set(ul,{left:(0-stepxoff)+"px",transformPerspective:300,ease:easeMe});
									else
										punchgs.TweenLite.set(ul,{x:(0-stepxoff)+"px",transformPerspective:300,ease:easeMe});
									off = off+1;
									stepxoff=(step*off);

								}

								if (off < 0) {
									off = 1;
									container.data('currentoffset',0);
									stepxoff=(step*off);
									ul.find('>li').last().prependTo(ul);
									if (isIE(8))
										punchgs.TweenLite.set(ul,{left:(0-stepxoff)+"px",transformPerspective:300,ease:easeMe});
									else
										punchgs.TweenLite.set(ul,{x:(0-stepxoff)+"px",transformPerspective:300,ease:easeMe});
									off = 0;
									stepxoff=(step*off);

								}
								if (isIE(8))
									punchgs.TweenLite.to(ul,speed/1000,{left:(0-stepxoff)+"px",transformPerspective:300,ease:easeMe});
								else
									punchgs.TweenLite.to(ul,speed/1000,{x:(0-stepxoff)+"px",transformPerspective:300,ease:easeMe});

						}


					},mrDelay)



					// SET THE HEIGHTS OF THE OUTTER CONTIANER

					var hbo=0;
					if (container.data('hboffset')!=undefined) hbo=container.data('hboffset');
					setTimeout(function() {
							var aktheight=0;
							ul.find('li').each(function(){
									if (jQuery(this).outerHeight(true)>aktheight) aktheight=jQuery(this).outerHeight(true);
							});
							setTimeout(function() {

								if (step>100) {
									var last=ul.find('>li:last-child');
									var secnd= ul.find('>li:nth(2)');
									var w=(last.index()+1)*last.outerWidth(true)+space;
									ul.css({'width':w+"px"});
								}
							},200);

							if (container.find('.tofullwidth.revactive .heightadjuster').length>0) {

								setRevContHeight(container,tr)
							} else {

								if (ul.parents(':hidden').length==0) {

									punchgs.TweenLite.to(ul,0.3,{height:(aktheight+hbo)+"px",ease:punchgs.Power3.easeInOut});
									punchgs.TweenLite.to(ul.parent(),0.3,{height:(aktheight+hbo)+"px",ease:punchgs.Power3.easeInOut});
									var navheight = container.find('.showbiz-navigation').outerHeight(true);

									punchgs.TweenLite.to(container.closest('.forcefullwidth_wrapper_tp_banner'),0.3,{height:(aktheight+hbo+navheight)+"px",ease:punchgs.Power3.easeInOut});
								}

							}


					 },speed+210)


		}

		/*********************************
			-	CHECK IF BROWSER IS IE	-
		********************************/
		function isIE( version, comparison ){
		    var $div = jQuery('<div style="display:none;"/>').appendTo(jQuery('body'));
		    $div.html('<!--[if '+(comparison||'')+' IE '+(version||'')+']><a>&nbsp;</a><![endif]-->');
		    var ieTest = $div.find('a').length;
		    $div.remove();
		    return ieTest;
		}




}(jQuery));



/* FITVIDS */
(function(e,t){
		e.fn.fitVids=function(t){var n={customSelector:null};var r=document.createElement("div"),i=document.getElementsByTagName("base")[0]||document.getElementsByTagName("script")[0];r.className="fit-vids-style";r.innerHTML="­<style>               .fluid-width-video-wrapper {                 width: 100%;                              position: relative;                       padding: 0;                            }                                                                                   .fluid-width-video-wrapper iframe,        .fluid-width-video-wrapper object,        .fluid-width-video-wrapper embed {           position: absolute;                       top: 0;                                   left: 0;                                  width: 100%;                              height: 100%;                          }                                       </style>";i.parentNode.insertBefore(r,i);if(t){e.extend(n,t)}return this.each(function(){var t=["iframe[src*='player.vimeo.com']","iframe[src*='www.youtube.com']","iframe[src*='www.kickstarter.com']","object","embed"];if(n.customSelector){t.push(n.customSelector)}var r=e(this).find(t.join(","));r.each(function(){var t=e(this);if(this.tagName.toLowerCase()=="embed"&&t.parent("object").length||t.parent(".fluid-width-video-wrapper").length){return}var n=this.tagName.toLowerCase()=="object"?t.attr("height"):t.height(),r=n/t.width();if(!t.attr("id")){var i="fitvid"+Math.floor(Math.random()*999999);t.attr("id",i)}t.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",r*100+"%");t.removeAttr("height").removeAttr("width")})})}
})(jQuery)
