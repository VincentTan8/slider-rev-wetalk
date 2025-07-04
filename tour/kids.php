<style>
    .two-side-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 180px;
        padding: 60px 15px;

        flex-wrap: wrap;
    }

    .left-side {
        flex: 1;
        min-width: 300px;
        display: flex;
        flex-direction: column;
        justify-content: left;
    }

    .left-header {
        font-size: 40px;
        margin-bottom: 30px;
        color: #333;
        text-align: left;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
    }

    .checklist {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .checklist li {
        display: flex;
        align-items: center;
        font-size: 1.1rem;
        margin-bottom: 15px;
        color: #555;
    }

    .checklist li img {
        width: 24px;
        height: 24px;
        margin-right: 30px;
    }

    .right-side {
        flex: 1;
        min-width: 300px;
        display: flex;
        justify-content: center;
    }

    .right-side img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .two-side-container {
            flex-direction: column;
            gap: 40px;
            padding: 40px 20px;
        }

        .left-side,
        .right-side {
            width: 100%;
            text-align: center;
            align-items: center;
        }

        .left-header {
            font-size: 28px;
            text-align: center;
        }

        .checklist li {
            font-size: 1rem;
            justify-content: center;
            text-align: left;
        }

        .checklist li img {
            margin-right: 16px;
        }
    }
</style>
<div class="two-side-container">
    <div class="left-side">
        <h2 id="kids-title" class="left-header"></h2>
        <ul id="tour-takeaway" class="checklist">
            <!-- Sample takeaway -->
            <!-- <li>
                <img src="<?php //echo $imgDir ?>check.png" alt="check"> Takeaway 1
            </li> -->
        </ul>
    </div>
    <div class="right-side">
        <img src="<?php echo $imgDir ?>kids.png" alt="Kids Group">
    </div>
</div>