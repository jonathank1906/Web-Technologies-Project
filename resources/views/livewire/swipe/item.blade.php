<div class="m-auto md:p-10 w-full h-full relative">
    <div class="relative h-full md:h-[600px] w-full md:w-96 m-auto">

        @for ($currentModelId = 1; $currentModelId < 20; $currentModelId++)
        <div 
            @swipedleft.window="console.log('left')"
            @swipedright.window="console.log('right')"
            
            x-data="
            {
                isSwiping: false,
                swipingLeft: false,
                swipingRight: false,

                swipeRight: function() {
                    moveOutWidth = document.body.clientWidth * 1.5;
                    $el.style.transform = 'translate(' + moveOutWidth + 'px, -100px ) rotate(-30deg)';

                    setTimeout(() => {
                        $el.remove();
                    }, 300);

                    {{-- dispatch --}}
                    $dispatch('swipedright');
                },

                swipeLeft: function() {
                    moveOutWidth = document.body.clientWidth * 1.5;
                    $el.style.transform = 'translate(' + -moveOutWidth + 'px, -100px ) rotate(-30deg)';

                    setTimeout(() => {
                        $el.remove();
                    }, 300);

                    {{-- dispatch --}}
                    $dispatch('swipedleft');
                }
            }"
            x-init="
                element = $el;

                {{-- initialize hammer.js --}}
                var hammertime = new Hammer(element);


                {{-- let pan support all directions --}}
                hammertime.get('pan').set({
                    direction: Hammer.DIRECTION_ALL,
                    touchAction:'pan'
                });

                {{-- ON pan --}}
                hammertime.on('pan', function(event) {
                    isSwiping = true;

                    if (event.deltaX === 0) return;
                    if (event.center.x === 0 && event.center.y === 0) return;

                    {{-- Swiped right --}}
                    if(event.deltaX > 30){
                        swipingRight = false;
                        swipingLeft = true;
                    }

                    {{-- Swiped left --}}
                    else if(event.deltaX < -30){
                        swipingRight = true;
                        swipingLeft = false;
                    }

                    {{-- Rotate --}}
                    var rotate = event.deltaX/10;

                    {{-- Apply transformation to rotate only in X drirection --}}
                    event.target.style.transform = 'translate(' + event.deltaX + 'px,' + event.deltaY + 'px) rotate(' + rotate + 'deg)';
                });

                hammertime.on('panend', function(event) {
                    {{-- reset state --}}
                    isSwiping = false;
                    swipingLeft = false;
                    swipingRight = false;

                    {{-- -set threshold --}}
                    var horizontalThreshold = 200;
                    var verticalThreshold = 200;

                    {{-- Velocity threshold --}}
                    var velocityXThreshold = 0.5;
                    var velocityYThreshold = 0.5;

                    {{-- determine keep --}}
                    var keep = (
                        Math.abs(event.deltaX) < horizontalThreshold && 
                        Math.abs(event.velocityX) < velocityXThreshold && 
                        Math.abs(event.deltaY) < verticalThreshold && 
                        Math.abs(event.velocityY) < velocityYThreshold
                    )

                    if (keep) {
                        {{-- adjust the duration and timing needed --}}

                        event.target.style.transition = 'transform 0.3s ease-in-out';
                        event.target.style.transform = '';
                        $el.style.transform = '';

                        {{-- clear the transition --}}

                        setTimeout(() => {
                            event.target.style.transition = '';
                            event.target.style.transform = '';
                            $el.style.transform = '';
                        }, 300); //use same as duration
                    } else {
                        {{-- dynamic monitorsize --}}

                        var moveOutWidth = document.body.clientWidth;
                        var moveOutHeight = document.body.clientHeight;

                        {{-- Decide to push left or right --}}

                        {{-- Swipe right --}}

                        if (event.deltaX > 20) {
                            event.target.style.transform = 'translate(' + moveOutWidth + 'px, 10px)';
                            //$dispatch('swipedright');
                        }

                        {{-- Swipe left --}}
                        else if (event.deltaX < -20) {
                            event.target.style.transform = 'translate(' + - moveOutWidth + 'px, 10px)';
                            $dispatch('swipedleft'); 
                        }
                        event.target.remove();
                        $el.remove();
                    }
                });
            "
            :class="{'transform-none cursor-grab':isSwiping}"
            class="absolute inset-0 m-auto transform ease-in-out duration-300 rounded-xl cursor-pointer z-50"
        >
            <div class="h-full w-full">

                <div class="pointer-events-none">
                    <img src="https://randomuser.me/api/portraits/women/{{ rand(0, 99) }}.jpg" class="h-full w-full bg-center rounded-xl" draggable="false" />
                    
                    {{-- swiper indicators --}}
                    <span
                        x-cloak
                        :class="{'invisible': !swipingRight}"
                        class="border-2 rounded-md p-1 px-2 border-red-500 text-red-500 text-4xl capitalize font-extrabold top-10 left-5 -rotate-12 absolute z-5">
                        NEXT PLEASE
                    </span>
                    <span 
                        x-cloak
                        :class="{'invisible': !swipingLeft}"
                        class="border-2 rounded-md p-1 px-2 border-green-500 text-green-500 text-4xl capitalize font-extrabold top-10 right-5 rotate-12 absolute z-5">
                        FOLLOW
                    </span>
                    
                </div>
                {{-- information and actions--}}
                <section class="absolute inset-x-0 bottom-0 inset-y-1/2 py-2 bg-gradient-to-t from-black to-black/0 pointer-events-none">
                    <div class="flex flex-col h-ful gap-2.5 mt-auto p-5 text-white">
                        {{--personal details--}}
                        <div class="grid grid-cols-12 items-center">

                            <div class="col-span-10">
                            <h4 class="font-bold text-3xl">
                                {{fake()->name}}
                            </h4>

                            <p class="text-lg line-clamp-3">
                                lorem ipsum and so on yada yada
                            </p>

                            </div>

                        </div>
                        <div class="items-center">
                            {{-- -Action Buttons --}}
                            <div class="grid grid-cols-5 gap-1 items-center mt-auto">
                                
                                {{-- -rewind --}}
                                <button draggable="false"
                                    class="rounded-full border-2 pointer-events-auto group border-yellow-600 p-3 shrink-0 max-w-fit flex items-center text-yellow-600"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                        class="w-9 h-9 shrink-0 m-auto group-hover:scale-105 transition-transform strok-2 stroke-current">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                    </svg>
                                </button>
                                
                                {{-- -Swipe Left --}}
                                <button draggable="false"
                                    class="rounded-full border-2 pointer-events-auto group border-red-600 p-3 shrink-0 max-w-fit flex items-center text-red-600"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" 
                                        class="w-9 h-9 shrink-0 m-auto group-hover:scale-105 transition-transform">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                {{-- -Swipe Right --}}
                                <button draggable="false"
                                    class="rounded-full border-2 pointer-events-auto group border-green-600 p-3 shrink-0 max-w-fit flex items-center text-green-600"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" 
                                        class="w-9 h-9 shrink-0 m-auto group-hover:scale-105 transition-transform">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        @endfor
    </div>
</div>