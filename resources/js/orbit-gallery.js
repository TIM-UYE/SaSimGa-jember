function createOrbit(worldId, speed, radiusMin, radiusMax) {

    const world = document.getElementById(worldId);

    if (!world) 
        return;
    
    const cards = world.querySelectorAll(".orbit-card");

    /* SAFE AREA */
    const safeZone = 180;

    cards.forEach((card, index) => {

        const angle = (360 / cards.length) * index;

        /* ORBIT RADIUS */
        const radius = safeZone + radiusMin + Math.random() * (radiusMax - radiusMin);

        /* SPREAD LIKE REFERENCE */
        const offsetY = (Math.random() - 0.5) * 180;

        /* SMALL TILT */
        const rotateZ = (Math.random() - 0.5) * 2;

        /* BASE SCALE */
        const scale = 0.82 + Math.random() * 0.12;

        /* RANDOM SIZE */
        const sizeVariants = [
            100, 
            140, 
            180, 
            220, 
            260, 
            300, 
            340, 
        ];

        const randomSize = sizeVariants[Math.floor(Math.random() * sizeVariants.length)];

        card.dataset.angle = angle;
        card.dataset.radius = radius;
        card.dataset.offsetY = offsetY;
        card.dataset.rotateZ = rotateZ;
        card.dataset.scale = scale;
        card.dataset.size = randomSize;

    });

    let rotation = 0;

    function animate() {

        rotation += speed;

        cards.forEach((card) => {

            const angle = parseFloat(card.dataset.angle);

            const radius = parseFloat(card.dataset.radius);

            const offsetY = parseFloat(card.dataset.offsetY);

            const rotateZ = parseFloat(card.dataset.rotateZ);

            const scale = parseFloat(card.dataset.scale);

            const finalAngle = angle + rotation;

            const size = parseFloat(card.dataset.size);

            /* DEPTH */
            const depth = Math.cos(finalAngle * Math.PI / 180);

            /* SCALE DEPTH */
            const dynamicScale = scale + (depth * 0.22);

            /* BRIGHTNESS */
            const dynamicBrightness = 0.82 + ((depth + 1) / 2) * 0.18;

            /* DEPTH BLUR */
            const depthBlur = (1 - ((depth + 1) / 2)) * 0.8;

            /* Z INDEX */
            const dynamicZ = Math.floor((depth + 1) * 100);

            card
                .style
                .setProperty("--orbit-size", `${size}px`);

            /* TRANSFORM */
            card.style.transform = `
                translate(-50%, -50%)
                rotateY(${finalAngle}deg)
                translateZ(${radius}px)
                translateY(${offsetY}px)
                rotateY(${ - finalAngle}deg)
                rotateZ(${rotateZ}deg)
                scale(${dynamicScale})
            `;

            card.style.filter = `brightness(${dynamicBrightness})
     blur(${depthBlur}px)`;

            card.style.zIndex = dynamicZ;

        });

        requestAnimationFrame(animate);

    }

    animate();

}

/* =========================
   INIT
========================= */

/* BACK */
createOrbit("orbitBack", 0.09, 370, 490);

/* FRONT */
createOrbit("orbitFront", -0.09, 370, 420);