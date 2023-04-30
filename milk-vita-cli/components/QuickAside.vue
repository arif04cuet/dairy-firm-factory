<template>
<div>
	<!-- <div class="grid-container">
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/COxitqgJr1sJnIDe8-jiKhxDx1FrYbtRHKJ9z_hELisAlapwE9LUPh6fcXIfb5vwpbMl4xl9H9TRFPc5NOO8Sb3VSgIBrfRYvW6cUA" alt="">
            </div>
            <h5>Google</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/0rpHlrX8IG77awQMuUZpQ0zGWT7HRYtpncsuRnFo6V3c8Lh2hPjXnEuhDDd-OsLz1vua4ld2rlUYFAaBYk-rZCODmi2eJlwUEVsZgg" alt="">
            </div>
            <h5>Gmail</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/rCwHBRBJV4wFiEIN_Mlboj94_TGJxyJtBh-MBFL4y1aZdO4hb7_Uc_PpXRyAoN7O9m_Zc1wSyp3H1vsnb829QE7t9KyGNJY9A1a3QQ" alt="">
            </div>
            <h5>Drive</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/BwoectM66uur7vsy6UNtarl_XM67Uu7qUakYNj8nh2OuwczsPmwMSLy0BJ6YpN3IXXCytOJHWeVgXkY4NomrvVMgwLVqLjgsaR7Nng" alt="">
            </div>
            <h5>Play</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/Q7ckaTTrajYsW1h9YZr1zGTl-Hjca-3VSs5b8aoCQU2PMoc3O8ixrV09xvp-dEQ8crlB7d8XjAEYhBqVpeysvbLuoEq1dmBRdP9TcA" alt="">
            </div>
            <h5>Games</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/3_OFn2skqHXk-UQ-9RUdNrDl_HQJrMCxks5teQcUrF_bOSeDG1hD8j83FeD31W8hASZCvubzsGfumuJq8kvvSAq03wY87RZ7Otx_DF4" alt="">
            </div>
            <h5>Youtube</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/uiXSNPoLxHD9lI9mO6utnEIzkzOyXHPFmO-QEmkwWAHI-vn-s1dGk09mmkSdOrrnat7t9eztDk9XKLkfL9x21SlqOTjXfm8SpGAIEw" alt="">
            </div>
            <h5>Fit</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/V6C9KmBzAK48_si_jPMSgUrBhdCGL8-z8QMg-WvDqSdVdPXN-FZHrpCHaZaYAYuXCGK-G85sYRIy3PdqfXAS4QlXwQJTyNUPYCpz" alt="">
            </div>
            <h5>Keep</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/n3Eac1gPc5OTEh7Go1jemICnooceXtfs4VZW-4CPukCUi_doFsN9Q8njidksZ4KIFyPJVYtR7ZhLL16VoUJSPE1j74iTXT2xwCqq" alt="">
            </div>
            <h5>Meet</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/1_fX4sgnF_BnHbc3m7z4_yPnQUoKX_MaphaKOUokyGVCvMW3q8cwyCpWEYnhqsq6H9e9bYSAiV3hVKvAOpTRKeEVHJblk6GxxbKUZQ" alt="">
            </div>
            <h5>Photos</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/7PVOZrst09IF5Mk3RgdeTX1b6R5nwicqFECRx55ulRw0lhzFeTCXtb_xbIyJ2HDu-YZr3-wJaXr5oLlo8k9L142nbRZg6jUidnpE8g" alt="">
            </div>
            <h5>Shites</h5>
        </div>
        <div class="grid">
            <div>
                <img src="https://lh3.googleusercontent.com/yCF7mTvXRF_EhDf7Kun5_-LMYTbD2IL-stx_D97EzpACfhpGjY_Frx8NZw63rSn2dME0v8-Im49Mh16htvPAGmEOMhiTxDZzo6rB7MY" alt="">
            </div>
            <h5>Sheets</h5>
        </div>
    </div> -->
    <app-switcher></app-switcher>
</div>
</template>

<style scoped>
    .grid-container{
        width: 100%;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* grid-gap: 15px 20px; */
        /* padding: 10px 20px; */
        overflow: hidden;
    }
    .grid{
        padding: 10px 15px 2px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .grid:hover{
        background-color: #F1F3F4;
        border-radius: 10px;
        cursor: pointer;
    }
    .grid>div>img {
        width: 100%;
        height: 100%;
        display: block;
    }
    .grid>h5{
        margin: 10px 0px 5px;
    }
</style>