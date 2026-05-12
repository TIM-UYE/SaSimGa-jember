const orbitWorld = document.getElementById("orbitWorld");

if (orbitWorld) {

    let currentRotation = 0;
    let targetRotation = 0;

    /* =========================
AUTO ROTATION
========================= */

    function animateOrbit() {

        targetRotation += 0.03;

        currentRotation += (targetRotation - currentRotation) * 0.05;

        orbitWorld.style.transform = `
rotateX(-8deg)
rotateY(${currentRotation}deg)
`;

        requestAnimationFrame(animateOrbit);

    }

    animateOrbit();

    /* =========================
MOUSE PARALLAX
========================= */

    window.addEventListener("mousemove", (e) => {

        const x = (e.clientX / window.innerWidth - 0.5);

        targetRotation += x * 0.4;

    });

    /* =========================
TOUCH DRAG
========================= */

    let isDragging = false;
    let startX = 0;

    orbitWorld.addEventListener("touchstart", (e) => {

        isDragging = true;

        startX = e
            .touches[0]
            .clientX;

    });

    orbitWorld.addEventListener("touchmove", (e) => {

        if (!isDragging) 
            return;
        
        const deltaX = e
            .touches[0]
            .clientX - startX;

        targetRotation += deltaX * 0.005;

        startX = e
            .touches[0]
            .clientX;

    });

    orbitWorld.addEventListener("touchend", () => {

        isDragging = false;

    });

}
