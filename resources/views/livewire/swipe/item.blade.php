<div class="m-auto md:p-10 w-full h-full relative">
    

        <div class="relative h-full md:h-[600px] w-full md:w-96 m-auto">
        <div
        x-data="{
            isSwiping:false,
            swipingLeft:false,
            swipingRight:false,
            {{-- - 
            swipeRight: function(){

                moveOutWidth= document.body.clientWidth *1.5;

                $el.style.transform= 'translate(' +moveOutWidth+ 'px, -100px ) rotate(-30deg)';

                setTimeout(()=>{
                    $el.remove();
                },300);

                
                $dispatch('swipedright')
                
                }
                --}}
        }"
        x-init="
        element= $el;

        var hammertime= new Hammer(element);



        hammertime.get('pan').set({
            direction: Hammer.DIRECTION_ALL,
            touchAction:'pan'
        });

        hammertime.on('pan',function(event){
        
        console.log('Synekbeschte1')
        isSwiping=true;
        if(event.deltaX===0) return;
        if(event.center.x=== 0 && event.center.y===0) return;
        
        
        if(event.deltaX > 20){
            console.log('Synekgut2')
            swipingRight=false;
            swipingLeft=true;//true
        }
            
        else if(event.deltaX < -20){
            console.log('Synekgut3')
            swipingRight=true;//true
            swipingLeft=false;
        }
        
        {{-- Rotate --}}
        var rotate= event.deltaX/10;
        
        {{-- Apply transformation to rotate only in X drirection --}}
        event.target.style.transform= 'translate('+ event.deltaX+ 'px,' +event.deltaY +'px) rotate(' +rotate+ 'deg';
        
        
        });
        {{-- -reset state --}}
        hammertime.on('panend',function(event){
            isSwiping=false;
            swipingLeft=false;
            swipingRight=false;
            
        {{-- -set threshold --}}
        var horizontalThreshold=200;
        var verticalThreshold=200;

            });
        "

        :class="{'transform-none cursor-grab':isSwiping}"
        class="absolute inset-0 m-auto transform ease-in-out duration-300 rounded-xl bg-gray-500 cursor-pointer">
        

                <div class="h-full w-full">
                
                        <div 
                        style="background-image: url('https://picsum.photos/1200/800')"
                        class="h-full w-full bg-cover bg-center rounded-xl">



                        <div class="pointer-events-none">
                            <span
                            x-cloak
                            :class="{'invisible':!swipingRight}"
                            class="border-2 rounded-md p-1 px-2 border-red-500 text-red-500 text-4xl capitalize font-extrabold top-10 left-5 -rotate-12 absolute z-5">
                            NOPE
                            </span>
                            <span 
                            x-cloak
                            :class="{'invisible':!swipingLeft}"
                            class="border-2 rounded-md p-1 px-2 border-green-500 text-green-500 text-4xl capitalize font-extrabold top-10 right-5 rotate-12 absolute z-5">
                            LIKE
                            </span>
                            
                        </div>

                        <section class="absolute inset-x-0 bottom-0 inset-y-1/2 py-2 bg-gradient-to-t from-black to-black/0 pointer-events-none">
                        
                        <div class="flex flex-col h-ful gap-2.5 mt-auto p-5 text-white">

                            <div class="grid grid-cols-12 items-center">
                            </div>
                        
                            <div class="grid grid-cols-5 gap-1 items-center mt-auto">
                                <button draggable="false"
                                class="rounded-full border-2 pointer-events-auto group border-yellow-600 p-3 shrink-0 max-w-fit flex items-center text-yellow-600"
                                >
                                
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                class="w-9 h-9 shrink-0 m-auto group-hover:scale-105 transition-transform strok-2 stroke-current">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                /svg>



                                </button>
                            </div>
                        </div>
                        

                        </section>

                </div>
                </div>
        </div>
</div>