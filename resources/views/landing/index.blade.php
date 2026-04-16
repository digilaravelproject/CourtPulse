<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Court Pulse — India's Legal Professional Network</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --navy: #050812;
            --navy2: #080d1a;
            --navy3: #0b1120;
            --card: #0e1526;
            --card2: #111830;
            --card3: #141c35;
            --blue: #B4B4FE;
            --blue2: #9999f0;
            --blue-glow: rgba(180, 180, 254, 0.3);
            --blue-light: #d0d0ff;
            --accent: #B4B4FE;
            --border: rgba(255, 255, 255, 0.06);
            --border2: rgba(180, 180, 254, 0.35);
            --text: #CBD5E1;
            --text2: #94A3B8;
            --muted: #4A5568;
            --white: #F8FAFC;
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--navy);
            color: var(--text);
            font-family: 'Manrope', sans-serif;
            overflow-x: hidden;
            line-height: 1.6;
            font-weight: 400;
        }

        /* NAV */
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 18px 0;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(20px);
            background: rgba(5, 8, 18, 0.92);
            transition: padding .3s, background .3s;
        }

        .nav.scrolled {
            padding: 12px 0;
            background: rgba(5, 8, 18, .98);
        }

        .nav-inner {
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 9px;
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            color: var(--white);
            text-decoration: none;
            letter-spacing: .02em;
        }

        .logo-box {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            color: #050812;
            font-weight: 900;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-links a {
            font-size: .82rem;
            font-weight: 500;
            color: var(--text2);
            text-decoration: none;
            transition: color .2s;
            letter-spacing: .01em;
            position: relative;
            padding-bottom: 2px;
        }

        .nav-links a.active,
        .nav-links a:hover {
            color: var(--white);
        }

        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--blue);
            border-radius: 1px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-ghost {
            padding: 7px 16px;
            border-radius: 5px;
            font-size: .8rem;
            font-weight: 600;
            color: var(--text2);
            border: 1px solid var(--border);
            background: transparent;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            font-family: 'Manrope', sans-serif;
        }

        .btn-ghost:hover {
            color: white;
            border-color: rgba(255, 255, 255, .2);
        }

        .btn-primary {
            padding: 7px 18px;
            border-radius: 5px;
            font-size: .8rem;
            font-weight: 700;
            color: #050812;
            background: var(--blue);
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            font-family: 'Manrope', sans-serif;
            letter-spacing: .02em;
        }

        .btn-primary:hover {
            background: var(--blue2);
            color: #050812;
            transform: translateY(-1px);
        }

        .nav-burger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 4px;
        }

        .nav-burger span {
            width: 22px;
            height: 2px;
            background: var(--text2);
            border-radius: 1px;
            transition: all .3s;
        }

        .mob-menu {
            display: none;
            flex-direction: column;
            gap: 0;
            background: var(--navy2);
            border-top: 1px solid var(--border);
            padding: 20px 24px;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
        }

        .mob-menu a {
            padding: 12px 0;
            font-size: .9rem;
            color: var(--text2);
            text-decoration: none;
            border-bottom: 1px solid var(--border);
            font-weight: 500;
        }

        .mob-menu a:hover {
            color: white;
        }

        .mob-menu .mob-btns {
            display: flex;
            gap: 10px;
            padding-top: 16px;
        }

        /* HERO */
        .hero {
            background: var(--navy);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 100px 0 60px;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(180, 180, 254, .03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(180, 180, 254, .03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .hero-col-visual {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 50%;
            background: linear-gradient(135deg, #0a0f20 0%, #0d1428 60%, #0a0f1e 100%);
            clip-path: polygon(8% 0, 100% 0, 100% 100%, 0% 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-col-art {
            position: relative;
            width: 260px;
            height: 380px;
        }

        .col-stack {
            position: absolute;
            border-radius: 4px;
            background: linear-gradient(180deg, #1a2040 0%, #0e1628 100%);
            border: 1px solid rgba(180, 180, 254, .2);
        }

        .col-stack:nth-child(1) {
            width: 140px;
            height: 300px;
            left: 60px;
            top: 40px;
            transform: perspective(400px) rotateY(-8deg);
            background: linear-gradient(180deg, #1e2550, #0f1830);
        }

        .col-stack:nth-child(2) {
            width: 120px;
            height: 260px;
            left: 90px;
            top: 60px;
            transform: perspective(400px) rotateY(-5deg);
            background: linear-gradient(180deg, #181e42, #0c1225);
            opacity: .8;
        }

        .col-stack:nth-child(3) {
            width: 100px;
            height: 220px;
            left: 118px;
            top: 80px;
            transform: perspective(400px) rotateY(-2deg);
            background: linear-gradient(180deg, #141836, #090e1e);
            opacity: .6;
        }

        .hero-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(180, 180, 254, .12) 0%, transparent 70%);
            top: -100px;
            left: -150px;
            pointer-events: none;
        }

        .hero-glow2 {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(180, 180, 254, .08) 0%, transparent 70%);
            bottom: -50px;
            right: 20%;
            pointer-events: none;
        }

        .hero-inner {
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(180, 180, 254, .18);
            border: 1px solid rgba(180, 180, 254, .4);
            color: var(--accent);
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            padding: 5px 13px;
            border-radius: 3px;
            margin-bottom: 22px;
        }

        .hero-title {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(3rem, 7vw, 5.5rem);
            font-weight: 400;
            line-height: 0.95;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: -0.04em;
            margin-bottom: 24px;
        }

        .hero-title .accent {
            color: var(--accent);
        }

        .hero-desc {
            font-size: 1.05rem;
            color: var(--text2);
            max-width: 480px;
            line-height: 1.7;
            margin-bottom: 35px;
            font-weight: 400;
            letter-spacing: -0.01em;
        }

        .hero-btns {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .btn-hero-main {
            padding: 12px 24px;
            border-radius: 5px;
            font-size: .85rem;
            font-weight: 700;
            color: #050812;
            background: var(--blue);
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .25s;
            letter-spacing: .02em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-main:hover {
            background: var(--blue2);
            color: #050812;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px var(--blue-glow);
        }

        .btn-hero-outline {
            padding: 12px 24px;
            border-radius: 5px;
            font-size: .85rem;
            font-weight: 600;
            color: var(--text2);
            background: transparent;
            border: 1px solid var(--border2);
            cursor: pointer;
            text-decoration: none;
            transition: all .25s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-outline:hover {
            color: white;
            border-color: var(--accent);
            background: rgba(180, 180, 254, .1);
        }

        .hero-stats {
            display: flex;
            gap: 32px;
            padding-top: 28px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }

        .hstat-num {
            font-family: 'Manrope', sans-serif;
            font-size: 2.22rem;
            font-weight: 800;
            color: white;
            line-height: 1;
            letter-spacing: -0.03em;
        }

        .hstat-label {
            font-size: .68rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .09em;
            margin-top: 4px;
        }

        /* QUICK ACCESS */
        .quick-access {
            background: var(--navy2);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 40px 0;
        }

        .qa-inner {
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .qa-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .qa-title {
            font-family: 'Manrope', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            color: white;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .qa-nav-btns {
            display: flex;
            gap: 8px;
        }

        .qa-nav-btn {
            width: 28px;
            height: 28px;
            border-radius: 4px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--text2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        .qa-nav-btn:hover {
            border-color: var(--blue);
            color: var(--accent);
        }

        .qa-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }

        .qa-item {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 18px 16px;
            transition: all .25s;
            cursor: pointer;
        }

        .qa-item:hover {
            border-color: var(--border2);
            background: var(--card2);
            transform: translateY(-2px);
        }

        .qa-icon {
            margin-bottom: 10px;
        }

        .qa-icon svg {
            width: 22px;
            height: 22px;
            stroke: var(--accent);
            fill: none;
            stroke-width: 1.5;
        }

        .qa-name {
            font-size: .82rem;
            font-weight: 700;
            color: white;
            margin-bottom: 4px;
        }

        .qa-desc {
            font-size: .7rem;
            color: var(--text2);
            line-height: 1.5;
        }

        /* SHARED */
        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .section-label {
            font-size: .63rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: .14em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .section-head {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(2rem, 5vw, 2.85rem);
            font-weight: 800;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: -0.03em;
            line-height: 1.0;
        }

        .head-line {
            width: 36px;
            height: 3px;
            background: var(--blue);
            border-radius: 2px;
            margin-top: 10px;
        }

        .section-top {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .view-all {
            font-size: .78rem;
            color: var(--accent);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
            white-space: nowrap;
            transition: color .2s;
        }

        .view-all:hover {
            color: white;
        }

        /* UPDATES */
        .section-updates {
            padding: 80px 0;
            background: var(--navy);
        }

        .updates-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
        }

        .news-featured {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            transition: all .3s;
            cursor: pointer;
        }

        .news-featured:hover {
            border-color: var(--border2);
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, .4);
        }

        .news-feat-img {
            width: 100%;
            height: 200px;
            background: var(--card3);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .news-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--blue);
            color: #050812;
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .08em;
            padding: 4px 9px;
            border-radius: 3px;
            text-transform: uppercase;
        }

        .news-feat-body {
            padding: 22px;
        }

        .news-cat {
            font-size: .63rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: 9px;
        }

        .news-feat-title {
            font-family: 'Manrope', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            line-height: 1.15;
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }

        .news-feat-desc {
            font-size: .8rem;
            color: var(--text2);
            line-height: 1.7;
            margin-bottom: 14px;
        }

        .news-meta {
            font-size: .7rem;
            color: var(--muted);
        }

        .news-sidebar {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .news-mini {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: stretch;
            transition: all .25s;
            cursor: pointer;
        }

        .news-mini:hover {
            border-color: var(--border2);
        }

        .news-mini-img {
            width: 72px;
            flex-shrink: 0;
            background: var(--card3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .news-mini-img svg {
            width: 28px;
            height: 28px;
            stroke: rgba(255, 255, 255, 0.06);
            fill: none;
            stroke-width: 1.2;
        }

        .news-mini-body {
            padding: 12px 14px;
            flex: 1;
        }

        .news-mini-cat {
            font-size: .6rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .news-mini-title {
            font-size: .78rem;
            font-weight: 600;
            color: white;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .news-mini-date {
            font-size: .65rem;
            color: var(--muted);
        }

        /* SERVICES */
        .section-services {
            padding: 80px 0;
            background: var(--navy2);
            border-top: 1px solid var(--border);
        }

        .services-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .services-header .head-line {
            margin: 10px auto 0;
        }

        .services-sub {
            font-size: .85rem;
            color: var(--text2);
            margin-top: 12px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .svc-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 28px 22px;
            transition: all .3s;
            cursor: pointer;
        }

        .svc-card:hover {
            border-color: var(--border2);
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, .3);
        }

        .svc-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            background: rgba(180, 180, 254, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            transition: background .3s;
        }

        .svc-card:hover .svc-icon-wrap {
            background: var(--blue);
        }

        .svc-card:hover .svc-icon-wrap svg {
            stroke: #050812;
        }

        .svc-icon-wrap svg {
            width: 20px;
            height: 20px;
            stroke: var(--accent);
            fill: none;
            stroke-width: 1.5;
        }

        .svc-name {
            font-family: 'Manrope', sans-serif;
            font-size: 1.15rem;
            font-weight: 800;
            color: white;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: -0.01em;
        }

        .svc-desc {
            font-size: .77rem;
            color: var(--text2);
            line-height: 1.65;
            margin-bottom: 16px;
        }

        .svc-explore {
            font-size: .75rem;
            color: var(--accent);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: color .2s;
        }

        .svc-explore:hover {
            color: white;
        }

        /* SUPPORT */
        .section-support {
            padding: 80px 0;
            background: var(--navy);
            border-top: 1px solid var(--border);
        }

        .support-hero-banner {
            background: linear-gradient(135deg, var(--card2) 0%, #0c1530 100%);
            border: 1px solid var(--border2);
            border-radius: 12px;
            padding: 32px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .support-banner-badge {
            display: inline-block;
            background: rgba(180, 180, 254, .2);
            border: 1px solid rgba(180, 180, 254, .4);
            color: var(--accent);
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 3px;
            margin-bottom: 10px;
        }

        .support-banner-title {
            font-family: 'Manrope', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            text-transform: uppercase;
            letter-spacing: -0.035em;
            line-height: 1.0;
        }

        .support-banner-desc {
            font-size: .82rem;
            color: var(--text2);
            margin-top: 8px;
            max-width: 480px;
            line-height: 1.65;
        }

        .btn-join {
            padding: 12px 24px;
            border-radius: 5px;
            font-size: .83rem;
            font-weight: 700;
            color: #050812;
            background: var(--blue);
            border: none;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            transition: all .25s;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .btn-join:hover {
            background: var(--blue2);
            color: #050812;
        }

        .access-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .access-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 28px;
        }

        .access-card.highlighted {
            background: var(--card2);
        }

        .access-title {
            font-family: 'Manrope', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: white;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .access-icon {
            color: rgba(255, 255, 255, .1);
        }

        .access-icon svg {
            width: 28px;
            height: 28px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1;
        }

        .access-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 24px;
        }

        .access-list li {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            font-size: .8rem;
            color: var(--text2);
            line-height: 1.5;
        }

        .access-list li::before {
            content: '';
            width: 16px;
            height: 16px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 2px;
            background: rgba(180, 180, 254, .15) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23B4B4FE' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E") no-repeat center / 9px;
            border: 1px solid rgba(180, 180, 254, .4);
        }

        .btn-access-main {
            width: 100%;
            padding: 11px;
            border-radius: 5px;
            font-size: .8rem;
            font-weight: 700;
            color: #050812;
            background: var(--blue);
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: .06em;
            transition: all .25s;
        }

        .btn-access-main:hover {
            background: var(--blue2);
        }

        .btn-access-ghost {
            width: 100%;
            padding: 11px;
            border-radius: 5px;
            font-size: .8rem;
            font-weight: 700;
            color: var(--text2);
            background: transparent;
            border: 1px solid var(--border2);
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: .06em;
            transition: all .25s;
        }

        .btn-access-ghost:hover {
            color: white;
            border-color: var(--accent);
            background: rgba(180, 180, 254, .1);
        }

        /* EDITORIAL */
        .section-editorial {
            padding: 80px 0;
            background: var(--navy2);
            border-top: 1px solid var(--border);
        }

        .editorial-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .ed-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            transition: all .3s;
            cursor: pointer;
        }

        .ed-card:hover {
            border-color: var(--border2);
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, .4);
        }

        .ed-img {
            width: 100%;
            height: 150px;
            background: var(--card2);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .ed-img-pattern {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(180, 180, 254, .04) 1px, transparent 1px), linear-gradient(90deg, rgba(180, 180, 254, .04) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .ed-img-icon {
            position: relative;
            z-index: 1;
        }

        .ed-img-icon svg {
            width: 48px;
            height: 48px;
            stroke: rgba(255, 255, 255, 0.05);
            fill: none;
            stroke-width: 1;
        }

        .ed-type-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--card3);
            border: 1px solid var(--border);
            color: var(--accent);
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 3px;
        }

        .ed-body {
            padding: 20px;
        }

        .ed-label {
            font-size: .63rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .ed-title {
            font-family: 'Manrope', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            color: white;
            line-height: 1.3;
            margin-bottom: 10px;
            letter-spacing: -0.01em;
        }

        .ed-excerpt {
            font-size: .77rem;
            color: var(--text2);
            line-height: 1.65;
            margin-bottom: 12px;
        }

        .ed-meta {
            font-size: .66rem;
            color: var(--muted);
        }

        /* CONTACT */
        .section-contact {
            padding: 80px 0;
            background: var(--navy);
            border-top: 1px solid var(--border);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
        }

        .contact-form-wrap {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 32px;
        }

        .contact-title {
            font-family: 'Manrope', sans-serif;
            font-size: 2.8rem;
            font-weight: 800;
            color: white;
            text-transform: uppercase;
            letter-spacing: -0.04em;
            margin-bottom: 10px;
            line-height: 1.0;
        }

        .contact-desc {
            font-size: .85rem;
            color: var(--text2);
            margin-bottom: 28px;
            line-height: 1.7;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }

        .form-label {
            font-size: .73rem;
            font-weight: 600;
            color: var(--text2);
            text-transform: uppercase;
            letter-spacing: .07em;
        }

        .form-input {
            background: var(--navy2);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 12px 14px;
            color: white;
            font-size: .88rem;
            outline: none;
            transition: border .2s;
            font-family: 'Manrope', sans-serif;
        }

        .form-input:focus {
            border-color: rgba(180, 180, 254, .5);
            background: var(--navy3);
        }

        .form-input::placeholder {
            color: var(--muted);
        }

        .btn-send {
            padding: 13px 24px;
            border-radius: 5px;
            font-size: .85rem;
            font-weight: 700;
            color: #050812;
            background: var(--blue);
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: .06em;
            transition: all .25s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-send:hover {
            background: var(--blue2);
            transform: translateY(-1px);
        }

        .contact-info {
            background: var(--blue);
            border-radius: 12px;
            padding: 28px;
            display: flex;
            flex-direction: column;
        }

        .ci-head {
            font-family: 'Manrope', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: #050812;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            margin-bottom: 8px;
        }

        .ci-subhead {
            font-size: .78rem;
            color: rgba(5, 8, 18, .65);
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .ci-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 22px;
        }

        .ci-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 7px;
            background: rgba(5, 8, 18, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ci-icon-box svg {
            width: 16px;
            height: 16px;
            stroke: #050812;
            fill: none;
            stroke-width: 2;
        }

        .ci-label {
            font-size: .65rem;
            color: rgba(5, 8, 18, .6);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 3px;
        }

        .ci-val {
            font-size: .85rem;
            color: #050812;
            font-weight: 500;
            line-height: 1.4;
        }

        .ci-socials {
            margin-top: auto;
            padding-top: 22px;
            border-top: 1px solid rgba(5, 8, 18, .15);
        }

        .ci-socials-label {
            font-size: .68rem;
            color: rgba(5, 8, 18, .55);
            margin-bottom: 12px;
        }

        .socials-row {
            display: flex;
            gap: 8px;
        }

        .social-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: rgba(5, 8, 18, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #050812;
            text-decoration: none;
            transition: all .2s;
        }

        .social-btn:hover {
            background: rgba(5, 8, 18, .28);
            color: #050812;
        }

        /* FOOTER */
        footer {
            background: var(--navy2);
            border-top: 1px solid var(--border);
        }

        .footer-bar {
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: .95rem;
            color: var(--white);
            text-decoration: none;
            letter-spacing: 0.01em;
            flex-shrink: 0;
        }

        .footer-logo .logo-box {
            width: 26px;
            height: 26px;
            border-radius: 5px;
            font-size: .66rem;
        }

        .footer-nav {
            display: flex;
            align-items: center;
            gap: 24px;
            list-style: none;
            flex-wrap: wrap;
        }

        .footer-nav a {
            font-size: .74rem;
            color: var(--muted);
            text-decoration: none;
            transition: color .2s;
            font-weight: 500;
            white-space: nowrap;
        }

        .footer-nav a:hover {
            color: var(--white);
        }

        .footer-copy {
            font-size: .72rem;
            color: var(--muted);
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* REVEAL */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .65s ease, transform .65s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .d1 {
            transition-delay: .12s;
        }

        .d2 {
            transition-delay: .24s;
        }

        .d3 {
            transition-delay: .36s;
        }

        /* RESPONSIVE */
        @media (max-width: 991px) {

            .nav-links,
            .nav-actions {
                display: none;
            }

            .nav-burger {
                display: flex;
            }

            .mob-menu.open {
                display: flex;
            }

            .hero-inner {
                grid-template-columns: 1fr;
            }

            .hero-col-visual {
                display: none;
            }

            .updates-grid {
                grid-template-columns: 1fr;
            }

            .services-grid {
                grid-template-columns: 1fr 1fr;
            }

            .access-grid {
                grid-template-columns: 1fr;
            }

            .editorial-grid {
                grid-template-columns: 1fr 1fr;
            }

            .contact-grid {
                grid-template-columns: 1fr;
            }

            .qa-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .support-hero-banner {
                flex-direction: column;
                align-items: flex-start;
            }

            .footer-bar {
                height: auto;
                padding: 14px 24px;
                flex-wrap: wrap;
                gap: 10px;
            }
        }

        @media (max-width: 600px) {
            .hero {
                padding: 90px 0 50px;
            }

            .hero-title {
                font-size: 2.6rem;
            }

            .hero-stats {
                gap: 20px;
            }

            .hstat-num {
                font-size: 1.4rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .editorial-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .contact-title {
                font-size: 1.8rem;
            }

            .qa-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .section-top {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .footer-bar {
                flex-direction: column;
                align-items: flex-start;
                padding: 16px 24px;
                gap: 8px;
            }

            .footer-nav {
                gap: 14px;
            }
        }
    </style>
</head>

<body>

    <!-- NAV -->
    <nav class="nav" id="nav">
        <div class="nav-inner">
            <a href="#" class="nav-logo d-flex align-items-center">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Court Pulse Logo"
                    style="height:40px; width:auto; margin-right:8px;">
                Court Pulse
            </a>
            <div class="nav-links">
                <a href="#" class="active">Home</a>
                <a href="#support">Procedural Support</a>
                <a href="#updates">News</a>
                <a href="#services">Service Categories</a>
                <a href="#editorial">Blogs</a>
            </div>
            <div class="nav-actions">
                <a href="/login" class="btn-ghost">Sign In</a>
                <a href="/register" class="btn-primary">Join as Professional</a>
            </div>
            <div class="nav-burger" id="burger" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
        <div class="mob-menu" id="mobMenu">
            <a href="#">Home</a>
            <a href="#support">Procedural Support</a>
            <a href="#updates">News</a>
            <a href="#services">Service Categories</a>
            <a href="#editorial">Blogs</a>
            <div class="mob-btns">
                <a href="/login" class="btn-ghost" style="flex:1;text-align:center;">Sign In</a>
                <a href="/register" class="btn-primary" style="flex:1;text-align:center;">Join as Pro</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <header class="hero">
        <div class="hero-bg"></div>
        <div class="hero-glow"></div>
        <div class="hero-glow2"></div>
        <div class="hero-col-visual">
            <div class="hero-col-art">
                <div class="col-stack"></div>
                <div class="col-stack"></div>
                <div class="col-stack"></div>
            </div>
        </div>
        <div class="hero-inner">
            <div>
                <div class="hero-badge">The Sovereign Archive</div>
                <h1 class="hero-title">
                    A Platform That Gives
                    <span class="accent">Instant Access</span>
                    To Procedural<br>
                    Support
                </h1>
                <p class="hero-desc">Access high-tier legal protocols, clerk directories, and institutional filing
                    systems through an elite editorial lens. Curation meets efficiency.</p>
                <div class="hero-btns">
                    <a href="#" class="btn-hero-main">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4l3 3" />
                        </svg>
                        Start Procedure
                    </a>
                    <a href="#support" class="btn-hero-outline">
                        Explore Clerk Directory
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- QUICK ACCESS -->
    <section class="quick-access">
        <div class="qa-inner">
            <div class="qa-header">
                <div class="qa-title">Quick Access</div>
                <div class="qa-nav-btns">
                    <button class="qa-nav-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M15 18l-6-6 6-6" />
                        </svg>
                    </button>
                    <button class="qa-nav-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="qa-grid">
                <div class="qa-item">
                    <div class="qa-icon"><svg viewBox="0 0 24 24">
                            <rect x="4" y="2" width="16" height="20" rx="2" />
                            <path d="M8 6h8M8 10h8M8 14h5" />
                        </svg></div>
                    <div class="qa-name">Clerk Filing</div>
                    <div class="qa-desc">Instant access to court filing protocols and deadlines.</div>
                </div>
                <div class="qa-item">
                    <div class="qa-icon"><svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4l3 3" />
                        </svg></div>
                    <div class="qa-name">Support Help</div>
                    <div class="qa-desc">24/7 dedicated support for procedural inquiries.</div>
                </div>
                <div class="qa-item">
                    <div class="qa-icon"><svg viewBox="0 0 24 24">
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg></div>
                    <div class="qa-name">Tribunals</div>
                    <div class="qa-desc">Detailed breakdown of active tribunal jurisdictions.</div>
                </div>
                <div class="qa-item">
                    <div class="qa-icon"><svg viewBox="0 0 24 24">
                            <path
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg></div>
                    <div class="qa-name">Legal Norms</div>
                    <div class="qa-desc">Archive of sovereign legal standards and ethics.</div>
                </div>
                <div class="qa-item">
                    <div class="qa-icon"><svg viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg></div>
                    <div class="qa-name">Search</div>
                    <div class="qa-desc">Connect agents across all practice areas.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- UPDATES -->
    <section class="section-updates" id="updates">
        <div class="container">
            <div class="section-top reveal">
                <div>
                    <div class="section-head">Latest Updates</div>
                    <div class="head-line"></div>
                </div>
                <a href="#" class="view-all">View All Updates <svg width="14" height="14" fill="none"
                        stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg></a>
            </div>
            <div class="updates-grid">
                <div class="news-featured reveal">
                    <div class="news-feat-img">
                        <span class="news-badge">Institutional Reform</span>
                        <svg width="60" height="60" fill="none" stroke="rgba(255,255,255,0.04)" stroke-width="1"
                            viewBox="0 0 24 24">
                            <path
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="news-feat-body">
                        <div class="news-cat">Institutional Reform</div>
                        <div class="news-feat-title">New ROC Filing Amendments for 2024 Corporate Compliance</div>
                        <div class="news-feat-desc">Detailed analysis of the upcoming regulatory changes affecting
                            Registrar of Companies filing protocols and timelines.</div>
                        <div class="news-meta">Nov 15, 2024 &bull; 7 min read</div>
                    </div>
                </div>
                <div class="news-sidebar">
                    <div class="news-mini reveal d1">
                        <div class="news-mini-img"><svg viewBox="0 0 24 24">
                                <path
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
                            </svg></div>
                        <div class="news-mini-body">
                            <div class="news-mini-cat">Court Clerks</div>
                            <div class="news-mini-title">Digital Signature Integration for District Tribunal Filings
                            </div>
                            <div class="news-mini-date">Nov 14, 2024</div>
                        </div>
                    </div>
                    <div class="news-mini reveal d2">
                        <div class="news-mini-img"><svg viewBox="0 0 24 24">
                                <path
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
                            </svg></div>
                        <div class="news-mini-body">
                            <div class="news-mini-cat">IP Services</div>
                            <div class="news-mini-title">New Accelerated Patent Examination Procedure Guidelines</div>
                            <div class="news-mini-date">Nov 12, 2024</div>
                        </div>
                    </div>
                    <div class="news-mini reveal d3">
                        <div class="news-mini-img"><svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 8v4l3 3" />
                            </svg></div>
                        <div class="news-mini-body">
                            <div class="news-mini-cat">Advocate Support</div>
                            <div class="news-mini-title">Cross-Border Litigation: Mastering Jurisdictional Protocols
                            </div>
                            <div class="news-mini-date">Nov 10, 2024</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICE CATEGORIES -->
    <section class="section-services" id="services">
        <div class="container">
            <div class="services-header reveal">
                <div class="section-label">Procedural Pipelines</div>
                <div class="section-head">Service Categories</div>
                <div class="head-line"></div>
                <p class="services-sub">Specialized procedural pipelines designed for high-stakes legal administration.
                </p>
            </div>
            <div class="services-grid">
                <div class="svc-card reveal">
                    <div class="svc-icon-wrap"><svg viewBox="0 0 24 24">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3" />
                        </svg></div>
                    <div class="svc-name">Court Clerks</div>
                    <div class="svc-desc">Full logistical support for filing and case management across all levels of
                        the judiciary.</div>
                    <a href="#" class="svc-explore">Explore Clerks <svg width="12" height="12" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg></a>
                </div>
                <div class="svc-card reveal d1">
                    <div class="svc-icon-wrap"><svg viewBox="0 0 24 24">
                            <path
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg></div>
                    <div class="svc-name">IP Clerks</div>
                    <div class="svc-desc">Intellectual property filing, trademark monitoring, and patent search
                        procedures.</div>
                    <a href="#" class="svc-explore">Explore Clerks <svg width="12" height="12" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg></a>
                </div>
                <div class="svc-card reveal d2">
                    <div class="svc-icon-wrap"><svg viewBox="0 0 24 24">
                            <path
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg></div>
                    <div class="svc-name">ROC Agents</div>
                    <div class="svc-desc">Seamless Registrar of Companies filings and compliance management for
                        enterprises.</div>
                    <a href="#" class="svc-explore">Explore Clerks <svg width="12" height="12" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg></a>
                </div>
            </div>
        </div>
    </section>

    <!-- ADVOCATE SUPPORT -->
    <section class="section-support" id="support">
        <div class="container">
            <div class="support-hero-banner reveal">
                <div>
                    <div class="support-banner-badge">Advocate Centre</div>
                    <div class="support-banner-title">Advocate Support Network</div>
                    <p class="support-banner-desc">Access elite research, case drafting assistance, and jurisdictional
                        brief summaries tailored for high-profile litigation.</p>
                </div>
                <a href="/register" class="btn-join">Join as Advocate</a>
            </div>
            <div class="access-grid">
                <div class="access-card reveal">
                    <div class="access-title">
                        Professional Access
                        <span class="access-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="2" y="7" width="20" height="14" rx="2" />
                                <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16" />
                            </svg>
                        </span>
                    </div>
                    <ul class="access-list">
                        <li>Unlimited procedural archive access</li>
                        <li>Direct communication with tribunal clerks</li>
                        <li>Case tracking &amp; deadline alerts</li>
                    </ul>
                    <button class="btn-access-main" onclick="window.location='/login'">Sign In as
                        Professional</button>
                </div>
                <div class="access-card highlighted reveal d1">
                    <div class="access-title">
                        Guest Access
                        <span class="access-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </span>
                    </div>
                    <ul class="access-list">
                        <li>Public legal norms directory</li>
                        <li>Basic procedure manual viewing</li>
                        <li>Support center consultation</li>
                    </ul>
                    <button class="btn-access-ghost">Continue as Guest</button>
                </div>
            </div>
        </div>
    </section>

    <!-- EDITORIAL -->
    <section class="section-editorial" id="editorial">
        <div class="container">
            <div class="section-top reveal" style="margin-bottom:40px;">
                <div>
                    <div class="section-label">Editorial Insights</div>
                    <div class="section-head">The Latest Thinking in Legal Technology and Procedural Efficiency.</div>
                    <div class="head-line"></div>
                </div>
                <a href="#" class="view-all">View All Blogs <svg width="14" height="14" fill="none"
                        stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg></a>
            </div>
            <div class="editorial-grid">
                <div class="ed-card reveal">
                    <div class="ed-img">
                        <div class="ed-img-pattern"></div>
                        <div class="ed-type-badge">Tech</div>
                        <span class="ed-img-icon"><svg viewBox="0 0 24 24">
                                <path
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg></span>
                    </div>
                    <div class="ed-body">
                        <div class="ed-label">Tech</div>
                        <div class="ed-title">The Future of AI in Tribunal Case Scheduling</div>
                        <div class="ed-excerpt">How automation is reducing court backlog by optimizing filing timelines
                            across major metropolitan districts.</div>
                        <div class="ed-meta">March 2025 &bull; 8 min read</div>
                    </div>
                </div>
                <div class="ed-card reveal d1">
                    <div class="ed-img" style="background:var(--card3);">
                        <div class="ed-img-pattern"></div>
                        <div class="ed-type-badge">Efficiency</div>
                        <span class="ed-img-icon"><svg viewBox="0 0 24 24">
                                <path
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg></span>
                    </div>
                    <div class="ed-body">
                        <div class="ed-label">Efficiency</div>
                        <div class="ed-title">5 Procedural Hurdles Every Advocate Must Master</div>
                        <div class="ed-excerpt">Strategic insights into navigating complex ROC filing systems for
                            early-stage multinational corporations.</div>
                        <div class="ed-meta">February 2025 &bull; 6 min read</div>
                    </div>
                </div>
                <div class="ed-card reveal d2">
                    <div class="ed-img" style="background:#0a0f22;">
                        <div class="ed-img-pattern"></div>
                        <div class="ed-type-badge">Insight</div>
                        <span class="ed-img-icon"><svg viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg></span>
                    </div>
                    <div class="ed-body">
                        <div class="ed-label">Insight</div>
                        <div class="ed-title">Sovereign Data: Protecting Privileges in the Digital Era</div>
                        <div class="ed-excerpt">A deep dive into the encryption standards shaping high-stakes digital
                            legal transactions.</div>
                        <div class="ed-meta">January 2025 &bull; 10 min read</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT -->
    <section class="section-contact" id="contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-form-wrap reveal">
                    <div class="contact-title">Contact Us</div>
                    <p class="contact-desc">Have questions about procedural access or joining our professional network?
                        Our sovereign support team is standing by.</p>
                    <div class="form-row">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-input" placeholder="Jonathan Doe">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-input" placeholder="jd@firm.legal">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:16px;">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-input" placeholder="Inquiry about Procedural Support">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message</label>
                        <textarea class="form-input" rows="5" placeholder="How can we assist your practice?"
                            style="resize:none;"></textarea>
                    </div>
                    <button class="btn-send">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
                        </svg>
                        Send Message
                    </button>
                </div>
                <div class="contact-info reveal d1">
                    <div class="ci-head">Our Archive HQ</div>
                    <div class="ci-subhead">Reach our team for any procedural access queries or professional network
                        inquiries.</div>
                    <div class="ci-item">
                        <div class="ci-icon-box">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="ci-label">Global Secretariat</div>
                            <div class="ci-val">22, 2nd floor Garni, Executive Wing<br>Navi Mumbai, 700408, India</div>
                        </div>
                    </div>
                    <div class="ci-item">
                        <div class="ci-icon-box">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="ci-label">Inquiries</div>
                            <div class="ci-val">support@courtpulse.com<br>professionals@courtpulse.com</div>
                        </div>
                    </div>
                    <div class="ci-item">
                        <div class="ci-icon-box">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <div class="ci-label">Direct Line</div>
                            <div class="ci-val">+919137553823</div>
                        </div>
                    </div>
                    <div class="ci-socials">
                        <div class="ci-socials-label">Follow Court Pulse</div>
                        <div class="socials-row">
                            <a href="#" class="social-btn"><svg width="14" height="14" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg></a>
                            <a href="#" class="social-btn"><svg width="14" height="14" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg></a>
                            <a href="#" class="social-btn"><svg width="14" height="14" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" />
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                                </svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-bar">
            <a href="#" class="footer-logo">
                <div class="logo-box">CP</div>
                Court Pulse
            </a>
            <ul class="footer-nav">
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#contact">Contact Us</a></li>
                <li><a href="#">Careers</a></li>
            </ul>
            <div class="footer-copy">&copy; 2026 Digi Emperor</div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', () => {
            document.getElementById('nav').classList.toggle('scrolled', window.scrollY > 60);
        });

        function toggleMenu() {
            document.getElementById('mobMenu').classList.toggle('open');
        }

        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('visible');
            });
        }, {
            threshold: 0.08
        });
        document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

        const navLinks = document.querySelectorAll('.nav-links a');
        window.addEventListener('scroll', () => {
            const sections = ['updates', 'services', 'support', 'editorial', 'contact'];
            let current = '';
            sections.forEach(id => {
                const el = document.getElementById(id);
                if (el && window.scrollY >= el.offsetTop - 140) current = id;
            });
            navLinks.forEach(a => {
                const href = a.getAttribute('href');
                a.classList.toggle('active', href === '#' + current || (current === '' && href === '#'));
            });
        });
    </script>
</body>

</html>
