<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Início</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  <link href="ltr-6a8f5d2e.css" rel="stylesheet">
</head>

<body>
  <div id="root">
    <div data-reactroot="">
      <div class="_6t5Uh" style="height: 78px;">
        <div class="NbGcm">
          <div class="_3vDrO">
            <div class="_3I51r _2OF7V">
              <span class="oboa9 _3viv6 HCWXf _3PU7E _3JPjo"></span><span class="_386Yc">German</span><span class="_1icRZ _1k9o2 cCL9P"></span>
              <div class="_2LqjD">
                <ul class="_20LC5 _2HujR _1ZY-H">
                  <li class="qsrrc"></li>
                  <li class="_2uBp_ _1qBnH">Add a new course</li>
                </ul>
              </div>
            </div>
            <div class="_1ALvM"></div>
            <div class="_1G4t1 _3HsQj _2OF7V" data-test="user-dropdown">
              <span class="_3ROGm"><img class="_3Kp8s" src="//s3.amazonaws.com/duolingo-images/avatar/default_2/medium" alt="User Avatar"></span><span></span><span class="_2Vgy6 _1k0u2 cCL9P"></span>
              <ul class="_3q7Wh OSaWc _2HujR _1ZY-H">
                <li class="_31ObI _1qBnH"><span class="_3sWvR">Create a profile</span></li>
                <li class="_31ObI _1qBnH">
                  <a class="_3sWvR" data-test="sound-settings" href="/settings">Settings</a>
                </li>
                <li class="_31ObI _1qBnH">
                  <a class="_3sWvR" href="https://support.duolingo.com/hc/en-us">Help</a>
                </li>
                <li class="_31ObI _1qBnH"><span class="_3sWvR">Keyboard shortcuts</span></li>
                <li class="_31ObI _1qBnH"><span class="_3sWvR">Sign in</span></li>
              </ul>
            </div>
          </div><a style="margin-left: 45px; background-position: -234px; height: 35px; width: 235px; background-size: cover; background-image:url(dteaches.png);" class="NJXKT _1nAJB cCL9P _2s5Eb" data-test="topbar-logo" href="indexuser.php"></a>
          <div class="_3I8Kk"></div>
        </div><a class="_19E7J" href="/settings">Settings</a>
      </div>
      <div class="LFfrA _3MLiB">
        <div>
          <div class="_2_lzu">
            <div class="_21w25 _1E3L7">
              <h2><a class="_3TYgk _2LNlu cCL9P" href="/settings/coach"></a>Daily Goal</h2>
              <div class="_2PIra">
                <div class="Rbutm">
                  <span class="_25O1e _2na4C cCL9P _1wV8Y"></span>
                  <div class="-zeKA">
                    <span class="_3gA3V cQcsw">0/20</span>xp gained
                  </div>
                  <div class="_3Ttma">
                    <svg height="150" style="overflow: hidden; position: relative;" version="1.1" width="150" xmlns="http://www.w3.org/2000/svg">
                      <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                        Created with Raphaël 2.2.0
                      </desc>
                      <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                        <lineargradient gradienttransform="matrix(1 0 0 1 0 0)" id="meigt60-_fcc34b:20-_fe922e" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" x1="0" x2="0.57735" y1="1" y2="0">
                          <stop offset="20%" stop-color="rgb(252, 195, 75)" stop-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></stop>
                          <stop offset="100%" stop-color="rgb(254, 146, 46)" stop-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></stop>
                        </lineargradient>
                      </defs>
                      <circle cx="75" cy="75" fill="#e2e2e2" r="75" stroke="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                      <path d="M 75 75 L 75 0 A 75 75 0 0 1 75 0 Z" fill="url(https://www.duolingo.com/#meigt60-_fcc34b:20-_fe922e)" fill-opacity="1" opacity="1" stroke="#ffffff" style="opacity: 1; fill-opacity: 1; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                      <path d="M 75 75 L 75 0 A 75 75 0 1 1 75 0 Z" fill="#e2e2e2" stroke="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                      <circle cx="75" cy="75" fill="#ffffff" r="64" stroke="#ffffff" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                    </svg>
                  </div>
                </div>
                <div class="_1h5j2">
                  <div class="g-M5R">
                    0
                  </div><span>day streak</span>
                  <div class="g-M5R">
                    8
                  </div><span>hours left</span>
                </div>
              </div>
            </div>
          </div>
          <div class="_3MT-S">
            <div>
              <div class="_2hEQd _1E3L7">
                <div class="i12-l" data-test="skill-tree">
                  <div class="_21SAE">
                    <h2 class="_3jmuN">Choose your path!</h2>
                    <p class="_2e1Vv"><span>Beginners start at Basics 1.<br>
                    Advanced learners take a short test.</span></p>
                    <ul>
                      <li class="_2kpKa">
                        <a class="W1dac" data-test="blue skill-tree-link" href="/skill/de/Basics-1"><span class="_1z_vo _3hKMG _2VAWl"><span class="_1S5fj _3noOL _1pIdm _9l65a _3aw24"></span></span><span class="_3qO9M _33VdW _2kAyW _1nOmH">Basics 1</span></a>
                      </li>
                      <li class="_1A-Bp _2kpKa">or</li>
                      <li class="_2kpKa">
                        <a class="W1dac" data-test="green skill-tree-link" href="/placement/de"><span class="_1z_vo _3hKMG _1na3J"><span class="vZcYH _3noOL _3muof _9l65a _3aw24"></span></span><span class="_3qO9M _33VdW _2slrg _1nOmH">Placement test</span></a>
                      </li>
                    </ul>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="_3E7by yeYoR _1pIdm _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">The<span class="_2TMjc">0</span>/1</span></span>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="_3_0GG yeYoR _780Gf _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Basics 2<span class="_2TMjc">0</span>/2</span></span></span><span class="W1dac"><span class="_3hKMG _39kLK"><span class="_1pqi7 yeYoR _2-r5o _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Phrases<span class="_2TMjc">0</span>/5</span></span></span>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="zl2fe yeYoR _1ab2t _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Acc. Case<span class="_2TMjc">0</span>/6</span></span></span><span class="W1dac"><span class="_3hKMG _39kLK"><span class="_1pqi7 yeYoR _2-r5o _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Intro<span class="_2TMjc">0</span>/3</span></span></span>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="_1DyPd yeYoR nkLYZ _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Food 1<span class="_2TMjc">0</span>/6</span></span></span>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="Cs1oL yeYoR _3qUIk _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Animals 1<span class="_2TMjc">0</span>/3</span></span></span>
                  </div>
                  <div class="_2GJb6">
                    <a class="_2Ng5c _1kVHP _2Np2b IuaAn _1lig4 _3IS_q U-jcv" data-test="test-out-button" href="/bigtest/de/0">Test out of 8 skills</a>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="28CPA yeYoR ZBvSW _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Plurals<span class="_2TMjc">0</span>/4</span></span></span><span class="W1dac"><span class="_3hKMG _39kLK"><span class="_3BbWL yeYoR CzjXf _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Adjectives<span class="_2TMjc">0</span>/3</span></span></span>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="ghfdo yeYoR _1ZtKL _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Not<span class="_2TMjc">0</span>/1</span></span></span><span class="W1dac"><span class="_3hKMG _39kLK"><span class="_1aB_O yeYoR MXahD _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Question 1<span class="_2TMjc">0</span>/3</span></span></span>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="_2dwUt yeYoR _1-tfe _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Present 1<span class="_2TMjc">0</span>/4</span></span></span><span class="W1dac"><span class="_3hKMG _39kLK"><span class="_3SO2c yeYoR _3Bk-T _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Clothing<span class="_2TMjc">0</span>/3</span></span></span>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="_3L3ru yeYoR f1-xH _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Nature 1<span class="_2TMjc">0</span>/3</span></span></span>
                  </div>
                  <div class="_2GJb6">
                    <a class="_2Ng5c _1kVHP _2Np2b IuaAn _1lig4 _3IS_q U-jcv" data-test="test-out-button" href="/bigtest/de/1">Test out of 15 skills</a>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="zl2fe yeYoR _1ab2t _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Pos. Pron.<span class="_2TMjc">0</span>/2</span></span></span><span class="W1dac"><span class="_3hKMG _39kLK"><span class="zl2fe yeYoR _1ab2t _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Nom. Pron.<span class="_2TMjc">0</span>/2</span></span></span>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="ghfdo yeYoR _1ZtKL _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Negatives<span class="_2TMjc">0</span>/2</span></span></span><span class="W1dac"><span class="_3hKMG _39kLK"><span class="_19dOe yeYoR _2tvfY _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Adverbs 1<span class="_2TMjc">0</span>/3</span></span></span>
                  </div>
                  <div class="_2GJb6">
                    <span class="W1dac"><span class="_3hKMG _39kLK"><span class="_3JgWX yeYoR _1BZ19 _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Places 1<span class="_2TMjc">0</span>/3</span></span></span><span class="W1dac"><span class="_3hKMG _39kLK"><span class="_3kiuQ yeYoR _3-1vq _9l65a _3aw24"></span></span><span class="AlP1u _33VdW">Stuff<span class="_2TMjc">0</span>/1</span></span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="_25CHT">
        <ul class="_3Qsaf">
          <li class="_3rBXe">
            <a class="_3n2f2 _3Tz38" href="/"><span class="JRo77 _1Xz_M cCL9P _3regV"></span>Learn</a>
          </li>
          <li class="_3rBXe">
            <a class="_3Tz38" href="javascript:;"><span class="_2-GwX _2Jh3u cCL9P _3regV"></span></a>
          </li>
          <li class="_3rBXe">
            <a class="_1SncI _3Tz38 _3Tz38" href="/show_store"><span class="OLFT9 _24x6W cCL9P _3regV"></span></a>
          </li>
          <li class="_3rBXe">
            <a class="_1SncI _3Tz38 _3Tz38" href="/labs"><span class="wbTkW XNdXe cCL9P _3regV"></span></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>