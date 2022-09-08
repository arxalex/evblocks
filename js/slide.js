var i = 0;
var slides = document.querySelectorAll('.slide');
var sbg = [];
var sit = [];
var sitc = [];
var svid = [];
var stoper;
console.log(slides);
slides.forEach(slide => {
    console.log(i);
    svid[i] = slide.querySelector('video');
    sbg[i] = slide.querySelector('.slide-background');
    sit[i] = slide.querySelector('.inner-text');
    sitc[i] = slide.querySelector('.inner-text-container');
    if(svid[i]){
        svid[i].pause();
    }
    sbg[i].style.transform = 'translate(100%, 0px)';
    sit[i].style.transform = 'translate(-100%, 0px)';
    gsap.to(sitc[i], {
        duration: 0,
        delay: 0,
        display: 'none',
    });
    i++;
    console.log(i);
});
if(svid[0]){
    svid[0].play();
}
sbg[0].style.transform = 'translate(0%, 0px)';
sit[0].style.transform = 'translate(0%, 0px)';
gsap.to(sitc[0], {
    duration: 0,
    delay: 0,
    display: 'block',
});
i = 0;
var tl = gsap.timeline();
var tween = tl.to(sbg[0], {
    duration: 0,
    x: '0%',
});
Draggable.create(document.createElement("div"), {
    trigger: '.slide-container',
    type: 'x',
    minimumMovement: 10,    
    dragClickables: true,
    throwProps: true,
    onDragStart: function () {
        if (this.getDirection() === "left") {
            next();
        } else {
            prev();
        }
    },
});

delay = 5000;

var timer = setInterval(() => {
    if (!tween.isActive()){
        next();
    }
}, delay);

function next() {
    if (!tween.isActive()) {
        i++;
        if (i >= sbg.length) {
            i = 0;
        }
        if(svid[i]){
            svid[i].play();
        }
        sbg[i].style.zIndex = '10';
        tween = tl.to(sbg[i], {
            duration: 0,
            delay: 0,
            x: '100%',
        });
        tween = tl.to(sbg[i], {
            duration: 2,
            delay: 0,
            x: '0%',
        });
        tween = tl.to(sit[i], {
            duration: 0.5,
            delay: -0.2,
            x: '0%',
        });
        tween = tl.to(sitc[i], {
            duration: 0,
            delay: -2.2,
            display: 'block',
        });
        i--;
        if (i < 0) {
            i = sbg.length - 1;
        }
        sbg[i].style.zIndex = '5';
        tween = tl.to(sbg[i], {
            duration: 2,
            delay: -2,
            x: '-50%',
        });
        tween = tl.to(sit[i], {
            duration: 0.5,
            delay: -2.2,
            x: '-100%',
        });
        tween = tl.to(sitc[i], {
            duration: 0,
            delay: 0,
            display: 'none',
        });
        tween = tl.to(sbg[i], {
            duration: 0,
            delay: 0,
            x: '-100%',
        });
        if(svid[i]){
            stoper = svid[i];
            setTimeout(() => stoper.pause(), 2000);
        }
        i++;
        if (i >= sbg.length) {
            i = 0;
        }
        clearInterval(timer);
        timer = setInterval(() => {
            if (!tween.isActive()){
                next();
            }
        }, delay);
    }
}
function prev() {
    if (!tween.isActive()) {
        i--;
        if (i < 0) {
            i = sbg.length - 1;
        }
        if(svid[i]){
            svid[i].play();
        }
        sbg[i].style.zIndex = '10';
        tween = tl.to(sbg[i], {
            duration: 0,
            delay: 0,
            x: '-100%',
        });
        tween = tl.to(sbg[i], {
            duration: 2,
            delay: 0,
            x: '0%',
        });
        tween = tl.to(sit[i], {
            duration: 0.5,
            delay: -0.2,
            x: '0%',
        });
        tween = tl.to(sitc[i], {
            duration: 0,
            delay: -2.2,
            display: 'block',
        });
        i++;
        if (i >= sbg.length) {
            i = 0;
        }
        sbg[i].style.zIndex = '5';
        tween = tl.to(sbg[i], {
            duration: 2,
            delay: -2,
            x: '50%',
        });
        tween = tl.to(sit[i], {
            duration: 0.5,
            delay: -2.2,
            x: '-100%',
        });
        tween = tl.to(sitc[i], {
            duration: 0,
            delay: 0,
            display: 'none',
        });
        tween = tl.to(sbg[i], {
            duration: 0,
            delay: 0,
            x: '100%',
        });
        if(svid[i]){
            stoper = svid[i];
            setTimeout(() => stoper.pause(), 2000);
        }
        i--;
        if (i < 0) {
            i = sbg.length - 1;
        }
        clearInterval(timer);
        timer = setInterval(() => {
            if (!tween.isActive()){
                next();
            }
        }, delay);
    }
}