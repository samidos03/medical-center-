import {
  Document, Packer, Paragraph, TextRun, Table, TableRow, TableCell,
  Header, Footer, AlignmentType, HeadingLevel, BorderStyle, WidthType,
  ShadingType, VerticalAlign, PageNumber, PageBreak, LevelFormat,
  TabStopType, TabStopPosition, TableOfContents, PositionalTab,
  PositionalTabAlignment, PositionalTabRelativeTo, PositionalTabLeader,
  ExternalHyperlink
} from "docx";

import fs from "fs";

// ── Palette simple et professionnelle ──
const NAVY      = "1F3864";
const DARK_RED  = "C0392B";
const BLACK     = "1A1A1A";
const DARK_GREY = "404040";
const MID_GREY  = "666666";
const LIGHT_BG  = "F2F5F9";
const WHITE     = "FFFFFF";
const HDR_BG    = "1F3864";
const ALT_ROW   = "EBF0F7";
const BORDER_C  = "BFCAD9";

// ── Helpers ──
const brd = (color = BORDER_C, size = 4) => ({ style: BorderStyle.SINGLE, size, color });
const noBrd = () => ({ style: BorderStyle.NONE, size: 0, color: WHITE });
const allBorders = (c = BORDER_C, s = 4) => ({ top: brd(c,s), bottom: brd(c,s), left: brd(c,s), right: brd(c,s) });

// ── Paragraph body ──
function body(text, opts = {}) {
  return new Paragraph({
    alignment: opts.center ? AlignmentType.CENTER : AlignmentType.JUSTIFIED,
    spacing: { before: opts.before || 0, after: opts.after || 160 },
    indent: opts.indent ? { left: 360 } : undefined,
    children: [new TextRun({
      text,
      font: "Arial",
      size: opts.size || 22,
      color: opts.color || DARK_GREY,
      bold: opts.bold || false,
      italics: opts.italic || false,
    })]
  });
}

// ── Heading 1 ──
function h1(text) {
  return new Paragraph({
    heading: HeadingLevel.HEADING_1,
    spacing: { before: 400, after: 200 },
    border: { bottom: { style: BorderStyle.SINGLE, size: 8, color: DARK_RED, space: 4 } },
    children: [
      new TextRun({ text: text.toUpperCase(), font: "Arial", size: 28, bold: true, color: NAVY })
    ]
  });
}

// ── Heading 2 ──
function h2(text) {
  return new Paragraph({
    heading: HeadingLevel.HEADING_2,
    spacing: { before: 260, after: 140 },
    children: [
      new TextRun({ text: "▌ ", font: "Arial", size: 24, bold: true, color: DARK_RED }),
      new TextRun({ text, font: "Arial", size: 24, bold: true, color: NAVY })
    ]
  });
}

// ── Bullet item ──
function bullet(text) {
  return new Paragraph({
    spacing: { before: 60, after: 80 },
    numbering: { reference: "bullets", level: 0 },
    children: [new TextRun({ text, font: "Arial", size: 22, color: DARK_GREY })]
  });
}

// ── Caption ──
function caption(text) {
  return new Paragraph({
    alignment: AlignmentType.CENTER,
    spacing: { before: 80, after: 200 },
    children: [new TextRun({ text, font: "Arial", size: 18, italics: true, color: MID_GREY })]
  });
}

// ── Séparateur ──
function sep() {
  return new Paragraph({
    spacing: { before: 160, after: 0 },
    border: { bottom: { style: BorderStyle.SINGLE, size: 4, color: BORDER_C, space: 1 } },
    children: []
  });
}

// ── Espace vide ──
function space(before = 120) {
  return new Paragraph({ spacing: { before, after: 0 }, children: [] });
}

// ── Tableau général ──
function makeTable(headers, rows, colWidths) {
  const headerRow = new TableRow({
    tableHeader: true,
    children: headers.map((h, i) =>
      new TableCell({
        width: { size: colWidths[i], type: WidthType.DXA },
        shading: { fill: HDR_BG, type: ShadingType.CLEAR },
        borders: allBorders(HDR_BG, 6),
        margins: { top: 100, bottom: 100, left: 150, right: 150 },
        verticalAlign: VerticalAlign.CENTER,
        children: [new Paragraph({
          alignment: AlignmentType.CENTER,
          children: [new TextRun({ text: h, font: "Arial", size: 20, bold: true, color: WHITE })]
        })]
      })
    )
  });

  const dataRows = rows.map((row, ri) =>
    new TableRow({
      children: row.map((cell, ci) =>
        new TableCell({
          width: { size: colWidths[ci], type: WidthType.DXA },
          shading: { fill: ri % 2 === 0 ? WHITE : ALT_ROW, type: ShadingType.CLEAR },
          borders: allBorders(BORDER_C, 4),
          margins: { top: 80, bottom: 80, left: 150, right: 150 },
          verticalAlign: VerticalAlign.CENTER,
          children: [new Paragraph({
            children: [new TextRun({ text: cell, font: "Arial", size: 19, color: DARK_GREY })]
          })]
        })
      )
    })
  );

  return new Table({
    width: { size: colWidths.reduce((a, b) => a + b, 0), type: WidthType.DXA },
    columnWidths: colWidths,
    rows: [headerRow, ...dataRows]
  });
}

// ── Bloc monospace (arborescence / maquette) ──
function codeLines(lines) {
  return lines.map(line =>
    new Paragraph({
      spacing: { before: 0, after: 0 },
      shading: { fill: "F4F4F4", type: ShadingType.CLEAR },
      indent: { left: 360, right: 360 },
      children: [new TextRun({ text: line, font: "Courier New", size: 18, color: "2C3E50" })]
    })
  );
}

// ═══════════════════════════════════════
// DOCUMENT
// ═══════════════════════════════════════
const doc = new Document({
  numbering: {
    config: [
      {
        reference: "bullets",
        levels: [{
          level: 0,
          format: LevelFormat.BULLET,
          text: "\u2022",
          alignment: AlignmentType.LEFT,
          style: { paragraph: { indent: { left: 540, hanging: 260 } } }
        }]
      }
    ]
  },
  styles: {
    default: {
      document: { run: { font: "Arial", size: 22, color: DARK_GREY } }
    },
    paragraphStyles: [
      {
        id: "Heading1", name: "Heading 1", basedOn: "Normal", next: "Normal", quickFormat: true,
        run: { size: 28, bold: true, font: "Arial", color: NAVY },
        paragraph: { spacing: { before: 400, after: 200 }, outlineLevel: 0 }
      },
      {
        id: "Heading2", name: "Heading 2", basedOn: "Normal", next: "Normal", quickFormat: true,
        run: { size: 24, bold: true, font: "Arial", color: NAVY },
        paragraph: { spacing: { before: 260, after: 140 }, outlineLevel: 1 }
      }
    ]
  },
  sections: [{
    properties: {
      page: {
        size: { width: 11906, height: 16838 },
        margin: { top: 1134, right: 1134, bottom: 1134, left: 1134 }
      }
    },

    // ── EN-TÊTE ──
    headers: {
      default: new Header({
        children: [new Paragraph({
          spacing: { before: 0, after: 60 },
          border: { bottom: { style: BorderStyle.SINGLE, size: 6, color: DARK_RED, space: 4 } },
          tabStops: [{ type: TabStopType.RIGHT, position: 9026 }],
          children: [
            new TextRun({ text: "The Powerpuff Girls  —  Mini-Projet POO C++", font: "Arial", size: 18, color: MID_GREY }),
            new TextRun({ text: "\tFSSM  2025 / 2026", font: "Arial", size: 18, color: DARK_RED }),
          ]
        })]
      })
    },

    // ── PIED DE PAGE ──
    footers: {
      default: new Footer({
        children: [new Paragraph({
          spacing: { before: 60, after: 0 },
          border: { top: { style: BorderStyle.SINGLE, size: 4, color: BORDER_C, space: 4 } },
          tabStops: [{ type: TabStopType.RIGHT, position: 9026 }],
          children: [
            new TextRun({ text: "Imane Ezzitouni  &  Fatima Zahra Loumilli", font: "Arial", size: 18, color: MID_GREY }),
            new TextRun({ text: "\tPage ", font: "Arial", size: 18, color: MID_GREY }),
            new TextRun({ children: [PageNumber.CURRENT], font: "Arial", size: 18, color: DARK_RED }),
          ]
        })]
      })
    },

    children: [

      // ══════════════════════════════════
      // PAGE DE GARDE
      // ══════════════════════════════════
      space(600),
      // Université
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 0, after: 80 },
        children: [new TextRun({ text: "Université Cadi Ayyad  —  FSSM Marrakech", font: "Arial", size: 20, color: MID_GREY })]
      }),
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 0, after: 80 },
        children: [new TextRun({ text: "Filières : INF-S4  &  IAP-S4   •   Module : POO en C++", font: "Arial", size: 20, color: MID_GREY })]
      }),
      space(240),
      // Filet rouge
      new Paragraph({
        spacing: { before: 0, after: 0 },
        border: { bottom: { style: BorderStyle.SINGLE, size: 18, color: DARK_RED, space: 1 } },
        children: []
      }),
      space(180),
      // Titre principal
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 0, after: 80 },
        children: [new TextRun({ text: "MINI-PROJET", font: "Arial", size: 22, bold: true, color: DARK_RED, allCaps: true })]
      }),
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 0, after: 100 },
        children: [new TextRun({ text: "Développement de Jeux Vidéo 2D avec SDL2", font: "Arial", size: 24, italics: true, color: DARK_GREY })]
      }),
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 80, after: 80 },
        children: [new TextRun({ text: "THE POWERPUFF GIRLS", font: "Arial", size: 52, bold: true, color: NAVY })]
      }),
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 0, after: 0 },
        children: [new TextRun({ text: "Les Super Nanas  —  Jeu d'action et d'esquive 2D", font: "Arial", size: 22, italics: true, color: MID_GREY })]
      }),
      space(180),
      // Filet fin
      new Paragraph({
        spacing: { before: 0, after: 0 },
        border: { bottom: { style: BorderStyle.SINGLE, size: 4, color: BORDER_C, space: 1 } },
        children: []
      }),
      space(300),
      // Infos
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 0, after: 100 },
        children: [
          new TextRun({ text: "Professeur : ", font: "Arial", size: 22, color: MID_GREY }),
          new TextRun({ text: "R. HANNANE", font: "Arial", size: 22, bold: true, color: BLACK }),
        ]
      }),
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 0, after: 100 },
        children: [
          new TextRun({ text: "Responsable du groupe : ", font: "Arial", size: 22, color: MID_GREY }),
          new TextRun({ text: "Fatima Zahra Loumilli", font: "Arial", size: 22, bold: true, color: BLACK }),
        ]
      }),
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 0, after: 100 },
        children: [
          new TextRun({ text: "Réalisé par : ", font: "Arial", size: 22, color: MID_GREY }),
          new TextRun({ text: "Imane Ezzitouni  &  Fatima Zahra Loumilli", font: "Arial", size: 22, bold: true, color: BLACK }),
        ]
      }),
      space(200),
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 0, after: 80 },
        children: [new TextRun({ text: "Année universitaire : 2025 / 2026", font: "Arial", size: 21, color: DARK_GREY })]
      }),
      new Paragraph({
        alignment: AlignmentType.CENTER,
        spacing: { before: 0, after: 80 },
        children: [new TextRun({ text: "Période : 30 mars 2026 – 23 avril 2026", font: "Arial", size: 21, color: DARK_GREY })]
      }),

      // Saut de page
      new Paragraph({ children: [new PageBreak()] }),

      // ══════════════════════════════════
      // TABLE DES MATIÈRES
      // ══════════════════════════════════
      new Paragraph({
        spacing: { before: 0, after: 260 },
        border: { bottom: { style: BorderStyle.SINGLE, size: 8, color: DARK_RED, space: 4 } },
        children: [new TextRun({ text: "TABLE DES MATIÈRES", font: "Arial", size: 28, bold: true, color: NAVY })]
      }),
      new TableOfContents("Table des matières", {
        hyperlink: true,
        headingStyleRange: "1-2",
      }),

      // Saut de page
      new Paragraph({ children: [new PageBreak()] }),

      // ══════════════════════════════════
      // 1. INTRODUCTION
      // ══════════════════════════════════
      h1("1.  Introduction"),
      body("Le présent rapport décrit la conception et le développement d'un jeu d'action et d'esquive en deux dimensions intitulé The Powerpuff Girls (Les Super Nanas), réalisé en langage C++ à l'aide de la bibliothèque multimédia SDL2 (Simple DirectMedia Layer). Ce mini-projet constitue une application concrète des notions de programmation orientée objet, de gestion de la mémoire, de décomposition modulaire et d'interfaçage avec une bibliothèque graphique bas niveau."),
      body("Le jeu s'inspire de la célèbre série animée The Powerpuff Girls, dans laquelle trois jeunes super-héroïnes — Blossom, Bubbles et Buttercup — protègent la ville de Townsville contre des forces du mal. Dans notre adaptation, le joueur incarne l'une des trois Super Nanas qui doit traverser la ville en volant à toute vitesse, évitant les attaques des ennemis (robots, tentacules de Mojo Jojo, bombes volantes) qui surgissent aléatoirement. L'objectif est d'atteindre le commissariat de Townsville avant l'expiration du chronomètre."),
      body("Sur le plan technique, SDL2 a été retenue pour sa nature multiplateforme, sa légèreté et son accès direct aux composants matériels (affichage, clavier, son). Les bibliothèques complémentaires SDL2_image, SDL2_ttf et SDL2_mixer permettent respectivement de charger des textures PNG, d'afficher le chronomètre et les informations de jeu, et de jouer la musique thème ainsi que les effets sonores d'action."),
      body("Ce rapport présente successivement la spécification des besoins, l'architecture modulaire adoptée, le détail des structures de données et des fonctions, les relations entre les modules, l'environnement de développement, les interfaces du jeu, la gestion des erreurs et une conclusion récapitulative."),
      sep(),

      // ══════════════════════════════════
      // 2. SPÉCIFICATION DES BESOINS
      // ══════════════════════════════════
      h1("2.  Spécification des besoins"),

      h2("2.1  Besoins fonctionnels"),
      body("Les besoins fonctionnels ont été identifiés à partir du cahier des charges et des choix de conception liés à l'univers The Powerpuff Girls.", { after: 180 }),
      makeTable(
        ["ID", "Description", "Priorité"],
        [
          ["BF-01", "Afficher un menu principal avec les options Jouer, À propos et Quitter.", "Haute"],
          ["BF-02", "Permettre au joueur de choisir sa Super Nana (Blossom, Bubbles ou Buttercup).", "Haute"],
          ["BF-03", "Lancer une partie avec un chronomètre décrémentant affiché à l'écran.", "Haute"],
          ["BF-04", "Permettre au joueur de déplacer la Super Nana (haut, bas, gauche, droite) au clavier.", "Haute"],
          ["BF-05", "Générer des ennemis et des obstacles aléatoirement (sol et air).", "Haute"],
          ["BF-06", "Détecter les collisions entre la Super Nana et les ennemis/obstacles.", "Haute"],
          ["BF-07", "Gérer les états du personnage : vivante (3 vies), blessée (2 puis 1 vie), hors combat.", "Haute"],
          ["BF-08", "Afficher une barre de vie et une barre de progression vers Townsville.", "Moyenne"],
          ["BF-09", "Afficher un écran de victoire lorsque le commissariat est atteint.", "Haute"],
          ["BF-10", "Afficher un écran de défaite si toutes les vies sont perdues ou le temps expiré.", "Haute"],
          ["BF-11", "Jouer la musique thème de la série et des effets sonores d'action.", "Moyenne"],
          ["BF-12", "Afficher une page À propos décrivant le contexte et les règles du jeu.", "Basse"],
        ],
        [1100, 6426, 1500]
      ),
      caption("Tableau 1 — Besoins fonctionnels de l'application The Powerpuff Girls"),

      h2("2.2  Besoins non fonctionnels"),
      bullet("Performance : le jeu doit maintenir 60 images par seconde pour garantir une animation fluide du vol et des effets d'action caractéristiques de la série."),
      bullet("Portabilité : le code C++ et SDL2 sont compilables sous Windows, Linux et macOS sans modification majeure."),
      bullet("Lisibilité : le code est découpé en modules cohérents (un fichier .h et un fichier .cpp par module) et documenté par des commentaires explicatifs."),
      bullet("Robustesse : toutes les erreurs d'initialisation SDL2, de chargement de ressources et d'allocation mémoire sont interceptées et affichées avant arrêt propre."),
      bullet("Maintenabilité : les constantes (vitesse de vol, durée, dimensions des sprites) sont centralisées dans un fichier d'en-tête dédié."),

      h2("2.3  Scénario de jeu"),
      body("Le joueur choisit l'une des trois Super Nanas au départ de la partie. Le personnage s'élance depuis le laboratoire du Professeur Utonium, situé à l'ouest de Townsville. Il doit traverser la ville en vol, esquivant les attaques de Mojo Jojo (bombes à retardement), des HIM (éclairs électriques) et des robots géants (projectiles). Chaque collision coûte une vie. Le jeu se termine par une victoire si la Super Nana rejoint le commissariat dans le temps imparti, ou par une défaite si toutes les vies sont épuisées ou si le chronomètre arrive à zéro."),
      sep(),

      // ══════════════════════════════════
      // 3. ARCHITECTURE
      // ══════════════════════════════════
      h1("3.  Architecture et conception du logiciel"),

      h2("3.1  Approche modulaire"),
      body("En C++, la structuration du code repose sur une décomposition modulaire orientée objet. Chaque module regroupe une classe (avec ses attributs et méthodes) qui encapsule un ensemble cohérent de responsabilités. Cette organisation garantit la séparation des préoccupations, un couplage faible et une forte cohésion interne."),
      body("Chaque module expose une interface publique claire via son fichier .h et masque ses détails d'implémentation dans son fichier .cpp. Les modules communiquent entre eux uniquement via les méthodes publiques déclarées dans leurs fichiers d'en-tête, facilitant ainsi la maintenance et l'extension du projet."),

      h2("3.2  Machine à états finis"),
      body("Le comportement global de l'application est gouverné par une machine à états finis. À chaque instant, le jeu se trouve dans l'un des états suivants :"),
      new Paragraph({
        spacing: { before: 100, after: 100 },
        shading: { fill: LIGHT_BG, type: ShadingType.CLEAR },
        indent: { left: 360 },
        children: [
          new TextRun({ text: "MENU", font: "Courier New", size: 22, color: DARK_RED, bold: true }),
          new TextRun({ text: "  →  ", font: "Arial", size: 22, color: MID_GREY }),
          new TextRun({ text: "CHARACTER_SELECT", font: "Courier New", size: 22, color: DARK_RED, bold: true }),
          new TextRun({ text: "  →  ", font: "Arial", size: 22, color: MID_GREY }),
          new TextRun({ text: "PLAYING", font: "Courier New", size: 22, color: DARK_RED, bold: true }),
          new TextRun({ text: "  →  ", font: "Arial", size: 22, color: MID_GREY }),
          new TextRun({ text: "WIN", font: "Courier New", size: 22, color: "27AE60", bold: true }),
          new TextRun({ text: "  /  ", font: "Arial", size: 22, color: MID_GREY }),
          new TextRun({ text: "GAME_OVER", font: "Courier New", size: 22, color: DARK_RED, bold: true }),
        ]
      }),
      caption("Figure 1 — Machine à états finis de The Powerpuff Girls"),
      sep(),

      // ══════════════════════════════════
      // 4. MODULES
      // ══════════════════════════════════
      h1("4.  Structure des modules et types de données"),

      h2("4.1  Module  hero  (hero.h / hero.c)"),
      body("Ce module définit la classe représentant la Super Nana choisie par le joueur, ainsi que toutes les méthodes qui la manipulent. Il encapsule la position de vol, les points de vie, l'identité du personnage (Blossom, Bubbles ou Buttercup) et le sprite associé à chacune.", { after: 180 }),
      makeTable(
        ["Attribut / Méthode", "Type", "Description"],
        [
          ["x, y", "float", "Position de la Super Nana dans la fenêtre (pixels)."],
          ["speedX, speedY", "float", "Vitesse de vol horizontale et verticale courante."],
          ["lives", "int", "Nombre de vies restantes (3 au départ)."],
          ["heroType", "HeroType (enum)", "Personnage : BLOSSOM, BUBBLES ou BUTTERCUP."],
          ["isInvincible", "bool", "Invincibilité temporaire après une collision (clignotement)."],
          ["texture", "SDL_Texture*", "Sprite SDL2 correspondant au personnage choisi."],
          ["rect", "SDL_Rect", "Rectangle de rendu et de collision."],
          ["hero_init()", "Hero*", "Alloue et initialise la Super Nana à la position de départ."],
          ["hero_handle_input()", "void", "Lit les touches clavier et met à jour la vitesse de vol."],
          ["hero_update(dt)", "void", "Applique la physique de vol à chaque frame."],
          ["hero_draw()", "void", "Dessine le sprite dans la fenêtre SDL."],
          ["hero_take_damage()", "void", "Réduit une vie et déclenche l'invincibilité temporaire."],
          ["hero_is_dead()", "bool", "Retourne true si toutes les vies sont épuisées."],
          ["hero_free()", "void", "Libère la mémoire et la texture SDL allouées."],
        ],
        [2700, 2000, 4326]
      ),
      caption("Tableau 2 — Attributs et méthodes du module hero"),

      h2("4.2  Module  enemy  (enemy.h / enemy.c)"),
      body("Ce module gère la génération, le déplacement et le rendu des ennemis et obstacles qui apparaissent aléatoirement pendant le vol. Les types d'ennemis sont inspirés des antagonistes de la série : Mojo Jojo (bombes), HIM (éclairs) et robots géants (projectiles).", { after: 180 }),
      makeTable(
        ["Attribut / Méthode", "Type", "Description"],
        [
          ["x, y", "float", "Position de l'ennemi/obstacle dans la fenêtre."],
          ["width, height", "int", "Dimensions pour la détection de collision."],
          ["type", "EnemyType (enum)", "Type : BOMB (Mojo), LIGHTNING (HIM), ROBOT_SHOT."],
          ["speed", "float", "Vitesse de déplacement vers la gauche."],
          ["active", "bool", "true si l'ennemi est actif, false s'il est sorti de l'écran."],
          ["texture", "SDL_Texture*", "Sprite SDL2 du type d'ennemi correspondant."],
          ["enemy_spawn()", "void", "Active un ennemi inactif à une position aléatoire."],
          ["enemy_update(dt)", "void", "Déplace tous les ennemis actifs."],
          ["enemy_draw()", "void", "Dessine tous les ennemis actifs."],
          ["enemy_check_collision()", "bool", "Retourne true si la Super Nana touche un ennemi."],
        ],
        [2700, 2000, 4326]
      ),
      caption("Tableau 3 — Attributs et méthodes du module enemy"),

      h2("4.3  Module  game  (game.h / game.c)"),
      body("Le module game est le chef d'orchestre de l'application. Il contient la boucle principale SDL2, coordonne tous les autres modules, gère le chronomètre et pilote la machine à états. C'est le point d'entrée logique de l'application après l'initialisation.", { after: 180 }),
      makeTable(
        ["Attribut / Méthode", "Type", "Description"],
        [
          ["window", "SDL_Window*", "Fenêtre principale SDL2."],
          ["renderer", "SDL_Renderer*", "Moteur de rendu matériel accéléré."],
          ["state", "GameState (enum)", "État courant : MENU, CHARACTER_SELECT, PLAYING, WIN, GAME_OVER."],
          ["timer", "float", "Temps restant avant la fin de la partie (secondes)."],
          ["distance", "float", "Distance parcourue vers le commissariat de Townsville."],
          ["game_init()", "bool", "Initialise SDL2, la fenêtre et le moteur de rendu."],
          ["game_run()", "void", "Lance la boucle principale (événements / update / rendu)."],
          ["game_update(dt)", "void", "Met à jour la logique selon l'état courant."],
          ["game_render()", "void", "Dessine la scène complète à chaque frame."],
          ["game_cleanup()", "void", "Libère toutes les ressources SDL et quitte proprement."],
        ],
        [2700, 2000, 4326]
      ),
      caption("Tableau 4 — Attributs et méthodes du module game"),

      h2("4.4  Module  hud  (hud.h / hud.c)"),
      body("Le module hud (Head-Up Display) gère l'affichage des informations à l'écran pendant la partie : chronomètre, barre de vie sous forme de cœurs aux couleurs des Super Nanas, et barre de progression indiquant la distance restante jusqu'au commissariat. Il utilise SDL2_ttf pour le rendu du texte avec une police TrueType."),

      h2("4.5  Module  audio  (audio.h / audio.c)"),
      body("Ce module encapsule l'utilisation de SDL2_mixer. Il expose des méthodes permettant de lancer la musique thème de la série, de jouer un effet sonore lors d'une collision (voix de Super Nana blessée), et de déclencher un son de victoire ou de défaite en fin de partie."),

      h2("4.6  Module  resources  (resources.h / resources.c)"),
      body("Ce module centralise le chargement et la libération de toutes les textures (sprites des Super Nanas, des ennemis, du décor de Townsville) et des polices de caractères. Il implémente un cache simple évitant les chargements redondants et constitue le point unique de contact avec SDL2_image et SDL2_ttf."),

      h2("4.7  Fichier  constants.h"),
      body("Ce fichier d'en-tête regroupe toutes les constantes du jeu sous forme de macros ou de constantes C++ : dimensions de la fenêtre, vitesse de vol initiale, durée du chronomètre, nombre de vies, fréquence d'apparition des ennemis, dimensions des sprites et seuils de collision. Centraliser ces valeurs facilite grandement l'ajustement des paramètres sans parcourir l'intégralité du code source."),
      sep(),

      // ══════════════════════════════════
      // 5. RELATIONS
      // ══════════════════════════════════
      h1("5.  Relations entre les modules"),
      body("Le tableau ci-dessous récapitule les dépendances entre les modules. Une dépendance signifie que le module source appelle des méthodes ou utilise des types définis dans le module cible.", { after: 180 }),
      makeTable(
        ["Module source", "Modules utilisés", "Nature de la relation"],
        [
          ["main.cpp", "game", "Instancie Game et appelle game_init(), game_run(), game_cleanup()."],
          ["game", "hero, enemy, hud, audio, resources", "Coordonne tous les modules à chaque frame de la boucle principale."],
          ["hero", "resources, constants.h", "Récupère ses textures (Blossom / Bubbles / Buttercup) via resources."],
          ["enemy", "resources, constants.h", "Idem hero pour les sprites de Mojo Jojo, HIM et robots."],
          ["hud", "SDL2_ttf, constants.h", "TTF_RenderText pour afficher le chrono, les vies et la progression."],
          ["audio", "SDL2_mixer", "Mix_PlayMusic() pour la musique thème, Mix_PlayChannel() pour les effets."],
          ["resources", "SDL2_image, SDL2_ttf", "IMG_LoadTexture() et TTF_OpenFont() pour toutes les ressources."],
        ],
        [2200, 2800, 4026]
      ),
      caption("Tableau 5 — Dépendances entre les modules de The Powerpuff Girls"),
      body("L'architecture respecte le principe de dépendance unidirectionnelle : les modules de haut niveau (game) dépendent des modules de bas niveau (hero, enemy, audio), mais jamais l'inverse. Le module resources est le seul à avoir connaissance directe de SDL2_image et SDL2_ttf."),
      sep(),

      // ══════════════════════════════════
      // 6. ENVIRONNEMENT
      // ══════════════════════════════════
      h1("6.  Environnement de travail"),

      h2("6.1  Outils et bibliothèques"),
      makeTable(
        ["Outil / Bibliothèque", "Version", "Rôle"],
        [
          ["GCC / G++", "13.x", "Compilation du code C++17."],
          ["SDL2", "2.30", "Gestion de la fenêtre, du rendu et des entrées clavier."],
          ["SDL2_image", "2.8", "Chargement des sprites PNG aux couleurs vives de la série."],
          ["SDL2_ttf", "2.22", "Rendu du chronomètre et des infos de jeu avec polices TrueType."],
          ["SDL2_mixer", "2.8", "Lecture de la musique thème et des effets sonores."],
          ["Visual Studio Code", "1.88", "Éditeur de code avec extension C/C++ et débogueur intégré."],
          ["Git", "2.43", "Gestion de versions et collaboration entre membres du binôme."],
          ["Make / CMake", "4.4", "Automatisation de la compilation via un Makefile."],
        ],
        [2600, 1400, 5026]
      ),
      caption("Tableau 6 — Outils et bibliothèques utilisés dans le projet"),

      h2("6.2  Structure des fichiers du projet"),
      space(80),
      ...codeLines([
        "PowerpuffGirls/",
        "├── Makefile",
        "├── include/",
        "│   ├── constants.h      (constantes globales : vies, chrono, vitesse...)",
        "│   ├── game.h           (boucle principale et machine à états)",
        "│   ├── hero.h           (classe et méthodes de la Super Nana)",
        "│   ├── enemy.h          (classe et méthodes des ennemis)",
        "│   ├── hud.h            (vies, chrono, barre de progression)",
        "│   ├── audio.h          (musique thème et effets sonores)",
        "│   └── resources.h      (chargement centralisé des ressources)",
        "├── src/",
        "│   ├── main.cpp",
        "│   ├── game.cpp",
        "│   ├── hero.cpp",
        "│   ├── enemy.cpp",
        "│   ├── hud.cpp",
        "│   ├── audio.cpp",
        "│   └── resources.cpp",
        "└── assets/",
        "    ├── textures/        (sprites Blossom, Bubbles, Buttercup, ennemis, décor)",
        "    ├── sounds/          (musique thème PPG, effets sonores d'action)",
        "    └── fonts/           (polices TrueType pour le HUD)",
      ]),
      space(80),
      caption("Figure 2 — Arborescence des fichiers du projet The Powerpuff Girls"),
      sep(),

      // ══════════════════════════════════
      // 7. INTERFACES
      // ══════════════════════════════════
      h1("7.  Interfaces du jeu"),
      body("L'application comporte six écrans principaux, chacun correspondant à un état de la machine à états. Les maquettes ci-dessous décrivent leur disposition et leur contenu, fidèlement à l'univers visuel coloré et dynamique de la série."),

      h2("7.1  Menu principal"),
      body("L'écran d'accueil affiche le titre du jeu sur un fond représentant le ciel de Townsville. Le logo The Powerpuff Girls est centré en haut, sous lequel trois boutons colorés sont disposés verticalement : Jouer (rose), À propos (bleu) et Quitter (vert). Les silhouettes des trois Super Nanas volent en arrière-plan en animation continue.", { after: 160 }),
      space(60),
      ...codeLines([
        "╔══════════════════════════════════════════════╗",
        "║    ★ ★ ★   THE POWERPUFF GIRLS   ★ ★ ★      ║",
        "║       Les Super Nanas – Sauvez Townsville !  ║",
        "║                                              ║",
        "║             [ ▶   Jouer        ]             ║",
        "║             [ ℹ   À propos     ]             ║",
        "║             [ ✖   Quitter      ]             ║",
        "║                                              ║",
        "║   Blossom  ✦  Bubbles  ✦  Buttercup en vol  ║",
        "╚══════════════════════════════════════════════╝",
      ]),
      caption("Figure 3 — Maquette du menu principal"),

      h2("7.2  Sélection du personnage"),
      body("Avant le lancement de la partie, le joueur choisit sa Super Nana parmi les trois héroïnes. Chaque personnage est présenté avec son sprite, son nom et une courte description de son pouvoir spécial : Blossom (rose) dispose d'un bouclier temporaire, Bubbles (bleue) est la plus rapide, et Buttercup (verte) inflige des dégâts aux ennemis au contact.", { after: 160 }),
      space(60),
      ...codeLines([
        "╔══════════════════════════════════════════════╗",
        "║       Choisissez votre Super Nana :          ║",
        "║                                              ║",
        "║  [ BLOSSOM ]    [ BUBBLES ]   [ BUTTERCUP ]  ║",
        "║    (Rose)        (Bleue)         (Verte)     ║",
        "║   Bouclier      Vitesse +       Contact DMG  ║",
        "║                                              ║",
        "║       Appuyez sur Entrée pour confirmer      ║",
        "╚══════════════════════════════════════════════╝",
      ]),
      caption("Figure 4 — Maquette de l'écran de sélection du personnage"),

      h2("7.3  Interface de jeu en cours de partie"),
      body("L'interface de jeu occupe l'intégralité de la fenêtre. La Super Nana vole à gauche de l'écran. Le décor de Townsville défile horizontalement en parallaxe. En haut à gauche, trois cœurs colorés indiquent les vies restantes. Au centre, une barre de progression montre la distance restante jusqu'au commissariat. À droite, le chronomètre décompte en temps réel.", { after: 160 }),
      space(60),
      ...codeLines([
        "♥ ♥ ♥       [====== Townsville ======►]       ⏱ 00:38",
        "────────────────────────────────────────────────────",
        "[BLOSSOM]  ···  [Bombe Mojo]  ···  [Éclair HIM]",
        "[BLOSSOM]  ···············  [Robot Shot]  ·······",
        "────────────────────────────────────────────────────",
        "[Immeuble]      [Immeuble]      [Immeuble]",
      ]),
      caption("Figure 5 — Maquette de l'interface en cours de partie"),

      h2("7.4  Écran de victoire et de défaite"),
      body("En cas de victoire, le maire de Townsville apparaît et remercie la joueuse. Le temps réalisé s'affiche. En cas de défaite (vies épuisées ou chronomètre à zéro), l'écran informe le joueur de la raison de l'échec. Dans les deux cas, des boutons Rejouer et Menu permettent de continuer.", { after: 160 }),
      space(60),
      ...codeLines([
        "★ VICTOIRE ★                    ✖ DÉFAITE ✖",
        "─────────────────────           ─────────────────────",
        "TOWNSVILLE EST SAUVÉE !         TOWNSVILLE A BESOIN",
        "Merci, Super Nana !             DE VOUS !",
        "Temps réalisé : 00:31           Mojo Jojo a triomphé...",
        "[ Rejouer ]  [ Menu ]           [ Rejouer ]  [ Menu ]",
      ]),
      caption("Figures 6-7 — Maquettes des écrans de victoire et de défaite"),

      h2("7.5  Contrôles du joueur"),
      makeTable(
        ["Touche", "Action"],
        [
          ["Flèche Haut / Z", "Monter en vol — esquiver un ennemi en dessous."],
          ["Flèche Bas / S", "Descendre en vol — esquiver un ennemi au-dessus."],
          ["Flèche Gauche / Q", "Ralentir — réduire la vitesse d'avance."],
          ["Flèche Droite / D", "Accélérer — augmenter la vitesse d'avance vers Townsville."],
          ["Échap", "Retour au menu principal depuis n'importe quel écran."],
        ],
        [2600, 6426]
      ),
      caption("Tableau 7 — Contrôles du joueur dans The Powerpuff Girls"),
      sep(),

      // ══════════════════════════════════
      // 8. GESTION DES ERREURS
      // ══════════════════════════════════
      h1("8.  Gestion des erreurs et robustesse"),
      body("La gestion des erreurs est un aspect fondamental de la robustesse du programme. Dans The Powerpuff Girls, plusieurs niveaux de vérification garantissent un comportement prévisible en toutes circonstances.", { after: 180 }),
      makeTable(
        ["Situation d'erreur", "Module", "Traitement appliqué"],
        [
          ["SDL_Init() échoue", "game.cpp", "Affichage de SDL_GetError() sur stderr, arrêt propre avec code d'erreur."],
          ["Création de fenêtre / renderer échouée", "game.cpp", "Même traitement ; message explicite pour le débogage."],
          ["Sprite introuvable (IMG_LoadTexture())", "resources.cpp", "Message d'erreur explicite, rectangle coloré de substitution."],
          ["Police TrueType introuvable", "hud.cpp", "Désactivation du rendu texte ; jeu continue sans affichage du chrono."],
          ["Fichier audio manquant", "audio.cpp", "Désactivation du son ; jeu continue sans musique ni effets sonores."],
          ["Allocation mémoire échouée (new)", "hero.cpp / enemy.cpp", "Exception std::bad_alloc interceptée ; arrêt propre avec message d'erreur."],
        ],
        [2800, 2200, 4026]
      ),
      caption("Tableau 8 — Stratégie de gestion des erreurs dans The Powerpuff Girls"),
      body("Toutes les fonctions d'initialisation retournent un booléen (true = succès, false = échec), permettant à la fonction appelante de réagir en conséquence. Cette convention garantit que chaque niveau de l'application est informé des défaillances des niveaux inférieurs et peut décider de poursuivre ou d'arrêter l'exécution de manière contrôlée."),
      sep(),

      // ══════════════════════════════════
      // 9. CONCLUSION
      // ══════════════════════════════════
      h1("9.  Conclusion"),
      body("Ce mini-projet a permis de développer une application de jeu vidéo 2D complète et originale, de la conception à l'implémentation, en exploitant les capacités de la bibliothèque SDL2. Le jeu The Powerpuff Girls offre une expérience d'action et d'esquive dynamique ancrée dans l'univers coloré et populaire de la série animée, alliant gameplay nerveux, animation fluide et ambiance sonore fidèle à l'esprit de la franchise."),
      body("Sur le plan technique, le projet a permis de mettre en pratique des compétences essentielles en développement logiciel : programmation orientée objet en C++, gestion de la mémoire, interfaçage avec des bibliothèques bas niveau (SDL2, SDL2_image, SDL2_ttf, SDL2_mixer), gestion des erreurs et organisation d'un projet multi-fichiers structuré autour de classes et de modules distincts. La machine à états finis adoptée pour gouverner le comportement de l'application constitue un patron de conception robuste et facilement extensible."),
      body("Parmi les améliorations envisageables pour les versions futures du jeu, on peut citer l'ajout d'un mode de difficulté progressive avec des ennemis plus rapides et plus nombreux, l'intégration de power-ups (bouclier supplémentaire, super-vitesse), un système de scores persistant permettant de comparer les meilleurs temps, ou encore l'ajout de nouveaux niveaux correspondant à différents quartiers de Townsville. Ces extensions s'intégreraient naturellement dans l'architecture modulaire mise en place dès la conception initiale du projet."),
      sep(),

      // ══════════════════════════════════
      // 10. RÉFÉRENCES
      // ══════════════════════════════════
      h1("10.  Références"),
      ...[
        "[1]  Documentation officielle SDL2  —  https://wiki.libsdl.org/SDL2/FrontPage",
        "[2]  Documentation SDL2_image  —  https://wiki.libsdl.org/SDL2_image/FrontPage",
        "[3]  Documentation SDL2_ttf  —  https://wiki.libsdl.org/SDL2_ttf/FrontPage",
        "[4]  Documentation SDL2_mixer  —  https://wiki.libsdl.org/SDL2_mixer/FrontPage",
        "[5]  B.W. Kernighan, D.M. Ritchie — The C Programming Language, 2e éd., Prentice Hall, 1988.",
        "[6]  Stroustrup, B. — The C++ Programming Language, 4e éd., Addison-Wesley, 2013.",
        "[7]  L. Zerbst, O. Duvel — Game Programming Demystified, Que Publishing, 2004.",
        "[8]  The Powerpuff Girls — Série animée créée par Craig McCracken, Cartoon Network, 1998–2005.",
        "[9]  Cours POO en C++ — Support de cours du module, FSSM Marrakech, 2025/2026.",
      ].map(ref =>
        new Paragraph({
          spacing: { before: 80, after: 80 },
          indent: { left: 200 },
          children: [new TextRun({ text: ref, font: "Arial", size: 20, color: DARK_GREY })]
        })
      ),
    ]
  }]
});

Packer.toBuffer(doc).then(buffer => {
  fs.writeFileSync("/mnt/user-data/outputs/Rapport_PowerpuffGirls_Loumilli_Ezzitouni.docx", buffer);
  console.log("Done.");
}).catch(err => {
  console.error("Error:", err);
  process.exit(1);
});