

class Boid {
    constructor(x, y) {
        this.note = notes[Math.floor(Math.random() * notes.length)];
        this.element = document.createElement('DIV');
        this.element.classList.add('boid');
        this.element.innerHTML = this.note;
        canvas.appendChild(this.element);

        if (x && y) {
            this.pos = new Vector(x, y);
        } else {
            this.pos = new Vector(Math.random() * w, Math.random() * h);
        }
        this.vel = new Vector((Math.random() - 0.5) * maxSpeed, (Math.random() - 0.5) * maxSpeed);
        this.theta = Math.random() * 10000;
    }


    edges() {
        if (this.pos.x > w) {
            this.pos.x = 0;
        } else if (this.pos.x < 0) {
            this.pos.x = w;
        }
        if (this.pos.y > h) {
            this.pos.y = 0;
        } else if (this.pos.y < 0) {
            this.pos.y = h;
        }
    }

    update() {
        this.pos.add(this.vel);
        this.theta += 0.02;
    }
    show() {
        const theta = Math.round(this.theta / 6.14 * 360 * 5) / 5;
        translateEntity(
            this.element, { x: this.pos.x, y: this.pos.y, rotate: theta, center: true }
        );
    }
}


const canvas = document.getElementById('jazz_canvas');
let w, h, notes, frameRate, maxSpeed, boids, noteCount;
if (canvas) {
    loadCanvas();
}

function loadCanvas() {

    w = canvas.clientWidth;
    h = canvas.clientHeight;
    frameRate = 20;
    noteCount = 20;
    notes = [
        "&#9833;",
        "&#9834;",
        "&#9835;",
        "&#9836;",
    ]
    maxSpeed = 10;

    window.addEventListener('resize', (e) => {
        w = parseInt(canvas.clientWidth);
        h = parseInt(canvas.clientHeight);
    })



    document.addEventListener('DOMContentLoaded', (event) => {
        setInterval(() => loop(), 1000 / frameRate);
    });


    boids = [];
    for (let i = 0; i < noteCount; i++) {
        addBoid();
    }

}



function loop() {
    for (let i = 0; i < boids.length; i++) {
        const boid = boids[i];
        boid.edges();
        boid.update();
        boid.show();
    }
}


function translateEntity(element, opts) {
    if (opts) {
        let t = '';

        if (opts.x && opts.y) {
            let x = opts.x;
            let y = opts.y;

            if (opts.center) {
                x -= (element.clientWidth / 2);
                y -= (element.clientHeight / 2);
            }
            t = `${t} translate(${x}px,${y}px )`;
        }

        if (opts.rotate) {
            let theta = opts.rotate;
            t = `${t} rotate(${theta}deg)`;
        }
        if (opts.scale) {
            let scale = opts.scale;
            t = `${t} scale(${scale})`;
        }
        element.style.transform = t;
    }


}

function addBoid() {
    const boid = new Boid();
    boids.push(boid)
}

