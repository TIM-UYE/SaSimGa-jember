function createOrbit(worldId, speed, radiusMin, radiusMax) {

    const world = document.getElementById(worldId);

    if (!world) 
        return;
    
    const cards = world.querySelectorAll(".orbit-card");

    /* SAFE AREA */
    const safeZone = 180;

    cards.forEach((card, index) => {

        const angle = (360 / cards.length) * index;

        /* RADIUS */
        const radius = safeZone + radiusMin + Math.random() * (radiusMax - radiusMin);

        /* SPREAD */
        const offsetY = (Math.random() - 0.5) * 180;

        /* SMALL TILT */
        const rotateZ = (Math.random() - 0.5) * 2;

        card.dataset.angle = angle;
        card.dataset.radius = radius;
        card.dataset.offsetY = offsetY;
        card.dataset.rotateZ = rotateZ;

    });

    let rotation = 0;

    function animate() {

        rotation += speed;

        cards.forEach((card) => {

            const angle = parseFloat(card.dataset.angle);

            const radius = parseFloat(card.dataset.radius);

            const offsetY = parseFloat(card.dataset.offsetY);

            const rotateZ = parseFloat(card.dataset.rotateZ);

            const finalAngle = angle + rotation;

            /* DEPTH */
            const depth = Math.cos(finalAngle * Math.PI / 180);

            /*
                belakang = kecil
                depan    = besar
            */

            const perspectiveScale = ((depth + 1) / 2);

            const dynamicScale = 0.72 + (perspectiveScale * 0.55);

            /* BRIGHTNESS */
            const dynamicBrightness = 0.82 + ((depth + 1) / 2) * 0.18;

            /* DEPTH BLUR */
            const depthBlur = (1 - ((depth + 1) / 2)) * 0.8;

            /* Z INDEX */
            let dynamicZ;

            /*
    depth > 0  = gambar di depan text
    depth <= 0 = gambar di belakang text
*/

            if (depth > 0) {

                dynamicZ = 120 + Math.floor(depth * 100);

            } else {

                dynamicZ = 20 + Math.floor((depth + 1) * 40);

            }

            /* TRANSFORM */
            card.style.transform = `
                translate(-50%, -50%)
                rotateY(${finalAngle}deg)
                translateZ(${radius +
                    (depth * 120)}px)
                translateY(${offsetY}px)
                rotateY(${ - finalAngle}deg)
                rotateZ(${rotateZ}deg)
                scale(${dynamicScale})
            `;

            /* DEPTH EFFECT */
            card.style.filter = `
                brightness(${dynamicBrightness})
                blur(${depthBlur}px)
            `;

            card.style.zIndex = dynamicZ;

        });

        requestAnimationFrame(animate);

    }

    animate();

}

/* INIT */

createOrbit("orbitWorld", 0.09, 370, 520);