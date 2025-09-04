@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero">
            <div class="hero-left">
                <h1>Spin, win, repeat.</h1>
                <p>Every game you play goes beyond entertainment — it fuels a meaningful mission. With each play, you're contributing to Paradise Fellowship, a 501(c)(3) nonprofit that aims to feed, house, and clothe the underserved population. Fiesta Sweeps isn't just about excitement; it's about creating real change, one play at a time.</p>
                <div class="hero-devices">
                    <img src="assets/gamingdevices.png" alt="Play on Any Device">
                </div>
            </div>
            <div class="hero-right">
                <img src="assets/herodevice.png" alt="Sign Up For Free Play">
                <div class="hero-text">
                    <h1>LIMITED TIME <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
  <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16m0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15"/>
</svg></h1>
                    <h2><span style="font-weight:900;color: #34bb82;">$10</span> FREE PLAY BONUS</h2>
                    <h2>JUST SIGN UP!</h2>
                    <a href="#" class="claim-button">Claim</a>
                </div>
            </div>
        </section>

        <section id="steps">
            <h2>Signing up is simple</h2>
            <p>Follow these steps to join our community of players.</p>
            <div class="steps-container">
                <div class="step-card">
                    <img src="assets/signup.png" alt="Create an Account">
                    <h3>Create an account</h3>
                    <p>Fill out your name, email, and phone number. We collect this information so you can always gain access to your account in case you lose it.</p>
                </div>
                <div class="step-card">
                    <img src="assets/welcome.png" alt="Claim your welcome bonus">
                    <h3>Claim your welcome bonus</h3>
                    <p>After creating your account, you can receive $10 in free play. Simply complete our verification process to qualify.</p>
                </div>
                <div class="step-card">
                    <img src="assets/playnow.png" alt="Play epic games">
                    <h3>Play epic games</h3>
                    <p>Make a donation or utilize your free play! Use your coins to play our exciting range of games for your chance to win amazing prizes.</p>
                </div>
            </div>
            <div class="cta-button-container">
                <a href="#" class="cta-button">Sign Up Today</a>
            </div>
        </section>

        <section id="games">
            <h2>Our Featured Games</h2>
            <div class="games-container">
                <div class="game-card" style="display:none;">
                    <img src="assets/orionstars.png" alt="Orion Stars">
                    <h3>Orion Stars</h3>
                    <p>An innovative sweepstakes and skill-based gaming platform that blends classic arcade-style games with modern technology. It offers a diverse range of games, including fish games, slot games, and skill-based challenges, making it appealing to both casual and competitive players.</p>
                </div>
                <div class="game-card" style="display:none;">
                    <img src="assets/juwa.png" alt="Juwa">
                    <h3>Juwa</h3>
                    <p>A skill-based gaming platform that specializes in fish table games, offering an engaging arcade-style experience. Players aim and shoot at virtual sea creatures, testing their precision and strategy. The game features 14 unique variations, each with different visuals, gameplay speeds, and objectives.</p>
                </div>
                <div class="game-card" style="display: none;">
                    <img src="assets/riversweeps.png" alt="River Sweeps">
                    <h3>River Sweeps</h3>
                    <p>A sweepstakes gaming platform that offers a variety of fish games, slot games, keno, and poker. It provides an engaging experience where players can compete in fish redemption shooter games, testing their skills to win prizes.</p>
                </div>
                <div class="game-card" style="display:none;">
                    <img src="assets/firekirin.png" alt="Fire Kirin">
                    <h3>Fire Kirin</h3>
                    <p>An arcade-style fish shooting game that combines skill, precision, and strategy. Players aim and shoot at various underwater creatures, each with different point values, to earn rewards.</p>
                </div>
                <div class="game-card">
                    <img src="assets/vblink.png" alt="VBlink">
                    <h3>VBlink</h3>
                    <p>A sweepstakes gaming platform that offers a mix of fish shooting games, slot machines, and skill-based challenges. It provides an engaging experience where players can compete in fish redemption shooter games, testing their skills to win prizes.</p>
                </div>
                <div class="game-card">
                    <img src="assets/ultrapanda.png" alt="Ultra Panda">
                    <h3>Ultra Panda</h3>
                    <p>An exciting online slot game that combines visually stunning graphics with engaging gameplay mechanics. The game features a five-reel slot format with multiple paylines, allowing players to match symbols for winning combinations.</p>
                </div>
                <div class="game-card"  style="display: none;">
                    <img src="assets/pandamaster.png" alt="Panda Master">
                    <h3>Panda Master</h3>
                    <p>An online gaming platform featuring a mix of fish games, slot games, blackjack, and keno. It offers a skill-based gaming experience, allowing players to test their precision and strategy in various game modes.</p>
                </div>
                <div class="game-card"  style="display: none;">
                    <img src="assets/vegassweeps.png" alt="Vegas Sweeps">
                    <h3>Vegas Sweeps</h3>
                    <p>A sweepstakes gaming platform that offers a variety of slot games, card games, fish games, keno, and blackjack. Unlike traditional online casinos, Vegas Sweeps operates under a sweepstakes model, allowing players to participate and win prizes without direct stake betting.</p>
                </div>
                <div class="game-card">
                    <img src="assets/gamevault.png" alt="Game Vault">
                    <h3>Game Vault</h3>
                    <p>An online gaming platform that offers a wide selection of casino-style games, including slots, fish games, keno, poker, and table games. It serves as a centralized hub where players can access multiple gambling-style games from a single app.</p>
                </div>
                <div class="game-card"  style="display: none;">
                    <img src="assets/egame.png" alt="EGame">
                    <h3>EGame</h3>
                    <p>An online gaming platform that blends classic casino-style games with modern slot mechanics for an engaging experience. It operates on a "Win What You See" system, meaning players can easily understand their winnings without complex paylines.</p>
                </div>
                <div class="game-card"  style="display: none;">
                    <img src="assets/bluedragon.png" alt="Blue Dragon">
                    <h3>Blue Dragon</h3>
                    <p>An online sweepstakes casino that offers a variety of games, including slots, fish table games, and poker. It provides a real-life casino atmosphere with fast-paced, high-energy gameplay designed to replicate the excitement of land-based casinos.</p>
                </div>
                <div class="game-card"  style="display: none;">
                    <img src="assets/mafia.png" alt="Mafia">
                    <h3>Mafia</h3>
                    <p>An online sweepstakes casino that combines slot machines, fish table games, and classic casino games into one platform. It offers a mix of fast-action slots, strategic table games, and interactive fish shooting games, catering to both casual and experienced players.</p>
                </div>

            </div>
        </section>
@endsection
