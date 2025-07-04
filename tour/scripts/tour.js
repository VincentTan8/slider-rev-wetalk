const imgDir = "../resources/img/educational-tour/";
const pageData = document.getElementById("page-data");
const pageLang = pageData.dataset.lang;
const destination = pageData.dataset.dest;

const fetchRemDestinations = async () => {
    //difference here from destinations js is that the dest is not included in the list
    try {
        const response = await fetch("scripts/fetch-remaining-destinations.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `language=${encodeURIComponent(pageLang)}` +
                `&destination_ref_num=${encodeURIComponent(destination)}`
        });
        const data = await response.json();

        const track = document.getElementById('carousel-parent');
        track.innerHTML = ''; // Clear existing static content if any

        let about = "About ";
        if (pageLang === '_cn')  //will have to add for other languages since this is not part of the data in db :<
            about = "关于";

        data.forEach(item => {
            const card = document.createElement('div');
            card.className = 'carousel-card';

            const isDisabled = item.ref_num === 'AUS';

            card.innerHTML = `
        <img src="${imgDir}${item.country_img}" alt="${item.country_name}">
        <h3>${item.country_name}</h3>
        <h4 class="carousel-subtitle">${item.card_header_text}</h4>
        <p>${item.card_description}</p>
        ${isDisabled ? `
            <div class="carousel-button disabled">
                <span>${about}${item.country_name}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="23" viewBox="0 0 29 23" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M17.2929 1.02385C17.6834 0.633326 18.3166 0.633326 18.7071 1.02385L28.7071 11.0239C29.0976 11.4144 29.0976 12.0475 28.7071 12.4381L18.7071 22.4381C18.3166 22.8286 17.6834 22.8286 17.2929 22.4381C16.9024 22.0475 16.9024 21.4144 17.2929 21.0238L25.5858 12.731H1C0.447715 12.731 0 12.2832 0 11.731C0 11.1787 0.447715 10.731 1 10.731H25.5858L17.2929 2.43806C16.9024 2.04754 16.9024 1.41437 17.2929 1.02385Z"
                        fill="#18181B" />
                </svg>
            </div>
        ` : `
            <a href="../tour?dest=${item.ref_num}" class="carousel-button">
                <span>${about}${item.country_name}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="23" viewBox="0 0 29 23" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M17.2929 1.02385C17.6834 0.633326 18.3166 0.633326 18.7071 1.02385L28.7071 11.0239C29.0976 11.4144 29.0976 12.0475 28.7071 12.4381L18.7071 22.4381C18.3166 22.8286 17.6834 22.8286 17.2929 22.4381C16.9024 22.0475 16.9024 21.4144 17.2929 21.0238L25.5858 12.731H1C0.447715 12.731 0 12.2832 0 11.731C0 11.1787 0.447715 10.731 1 10.731H25.5858L17.2929 2.43806C16.9024 2.04754 16.9024 1.41437 17.2929 1.02385Z"
                        fill="#18181B" />
                </svg>
            </a>
        `}
    `;
            track.appendChild(card);
        });

    } catch (error) {
        console.error("Error fetching destinations:", error);
    }
};

const fetchTour = async () => {
    try {
        const response = await fetch("scripts/fetch-tour-details.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `language=${encodeURIComponent(pageLang)}` +
                `&destination_ref_num=${encodeURIComponent(destination)}`
        });
        const entry = await response.json();
        const data = entry[0];

        let study_tour = " Study Tour";
        let why = "Why ";
        if (pageLang === '_cn') {  //will have to add for other languages since this is not part of the data in db :<
            study_tour = "游学团";
            why = "为什么选择";
        }

        document.getElementById('hero-section').style.backgroundImage = `url('${imgDir}${data.country_img}')`;
        document.getElementById('hero-title').innerHTML = `WeTalk <span id="hero-highlight" style="color:#F2AE14;">${data.country_name}</span>${study_tour}`;
        document.getElementById('hero-subtitle').textContent = data.header_text;
        document.getElementById('reason-text').textContent = data.description;
        document.getElementById('why-country').textContent = `${why}${data.country_name}?`;
        document.getElementById('why-img').src = imgDir + data.country_why_img;

        return data.ref_num;
    } catch (error) {
        console.error("Error fetching tour page details:", error);
    }
};

const fetchProgram = async (tour_ref_num) => {
    try {
        const response = await fetch("scripts/fetch-program-details.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `language=${encodeURIComponent(pageLang)}` +
                `&tour_details_ref_num=${encodeURIComponent(tour_ref_num)}`
        });
        const data = await response.json();

        const container = document.getElementById('highlight-parent');
        container.innerHTML = ''; // Clear existing static content if any

        data.forEach(item => {
            const card = document.createElement("div");
            card.className = "highlight-card";
            card.innerHTML = `
            <img src="${imgDir}${item.program_img}" alt="${item.title}" class="img-fluid mb-2">
            <p class="highlight-title">${item.title}</p>
            <p class="highlight-desc">${item.description}</p>
            `;

            container.appendChild(card);
        });
        document.querySelector('.glow-bg').style.background = `#66CDE7`;
    } catch (error) {
        console.error("Error fetching program details:", error);
    }
}

const fetchItinerary = async (tour_ref_num) => {
    try {
        const response = await fetch("scripts/fetch-itineraries.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `language=${encodeURIComponent(pageLang)}` +
                `&tour_details_ref_num=${encodeURIComponent(tour_ref_num)}`
        });
        const dayData = await response.json();

        const dayMarkers = document.querySelectorAll('.day-marker');

        dayMarkers.forEach((marker, index) => {
            const data = dayData[index];
            if (!data) return;

            // Update the day number
            const span = marker.querySelector('.day-circle span');
            span.textContent = data.day_no;

            // Update the description paragraph
            const p = marker.querySelector('p');
            if (p) {
                p.textContent = data.description;
            }
        });
    } catch (error) {
        console.error("Error fetching itineraries:", error);
    }
}

const fetchTakeaway = async (tour_ref_num) => {
    try {
        const response = await fetch("scripts/fetch-takeaways.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `language=${encodeURIComponent(pageLang)}` +
                `&tour_details_ref_num=${encodeURIComponent(tour_ref_num)}`
        });
        const data = await response.json();

        const list = document.getElementById("tour-takeaway");
        list.innerHTML = ""; //Clear if needed

        data.forEach(text => {
            const li = document.createElement("li");
            const img = document.createElement("img");
            img.src = imgDir + "check.png";
            img.alt = "check";

            li.appendChild(img);
            li.append(" " + text.takeaway); // Append text after image
            list.appendChild(li);
        });
    } catch (error) {
        console.error("Error fetching takeaways:", error);
    }
}

const fetchNextSteps = async (tour_ref_num) => {
    try {
        const response = await fetch("scripts/fetch-next-steps.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `language=${encodeURIComponent(pageLang)}` +
                `&tour_details_ref_num=${encodeURIComponent(tour_ref_num)}`
        });
        const entry = await response.json();
        const data = entry[0];

        document.getElementById('next-tour').textContent = data.info_1;
        document.getElementById('next-date').textContent = data.info_2;
        document.getElementById('early-bird').textContent = data.info_3;
        document.getElementById('early-deadline').textContent = data.info_4;
        document.getElementById('suitable-for').textContent = data.info_5;
        document.getElementById('next-includes').textContent = data.info_6;
    } catch (error) {
        console.error("Error fetching next steps:", error);
    }
}


$(document).ready(async function () {
    const tour_ref_num = await fetchTour();
    fetchRemDestinations();
    fetchProgram(tour_ref_num);
    fetchItinerary(tour_ref_num);
    fetchTakeaway(tour_ref_num);
    fetchNextSteps(tour_ref_num);
});
