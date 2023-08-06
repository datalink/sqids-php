<?php

/**
 * Copyright (c) Sqids maintainers.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/sqids/sqids-php
 */

namespace Sqids;

use Sqids\Math\BCMath;
use Sqids\Math\Gmp;
use Sqids\Math\MathInterface;
use InvalidArgumentException;
use RuntimeException;

class Sqids implements SqidsInterface
{
    final public const DEFAULT_ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    final public const DEFAULT_MIN_LENGTH = 0;
    final public const DEFAULT_BLOCKLIST = [
        "0rgasm",
        "1d10t",
        "1d1ot",
        "1di0t",
        "1diot",
        "1eccacu10",
        "1eccacu1o",
        "1eccacul0",
        "1eccaculo",
        "1mbec11e",
        "1mbec1le",
        "1mbeci1e",
        "1mbecile",
        "a11upat0",
        "a11upato",
        "a1lupat0",
        "a1lupato",
        "aand",
        "ah01e",
        "ah0le",
        "aho1e",
        "ahole",
        "al1upat0",
        "al1upato",
        "allupat0",
        "allupato",
        "ana1",
        "ana1e",
        "anal",
        "anale",
        "anus",
        "arrapat0",
        "arrapato",
        "arsch",
        "arse",
        "ass",
        "b00b",
        "b00be",
        "b01ata",
        "b0ceta",
        "b0iata",
        "b0ob",
        "b0obe",
        "b0sta",
        "b1tch",
        "b1te",
        "b1tte",
        "ba1atkar",
        "balatkar",
        "bastard0",
        "bastardo",
        "batt0na",
        "battona",
        "bitch",
        "bite",
        "bitte",
        "bo0b",
        "bo0be",
        "bo1ata",
        "boceta",
        "boiata",
        "boob",
        "boobe",
        "bosta",
        "bran1age",
        "bran1er",
        "bran1ette",
        "bran1eur",
        "bran1euse",
        "branlage",
        "branler",
        "branlette",
        "branleur",
        "branleuse",
        "c0ck",
        "c0g110ne",
        "c0g11one",
        "c0g1i0ne",
        "c0g1ione",
        "c0gl10ne",
        "c0gl1one",
        "c0gli0ne",
        "c0glione",
        "c0na",
        "c0nnard",
        "c0nnasse",
        "c0nne",
        "c0u111es",
        "c0u11les",
        "c0u1l1es",
        "c0u1lles",
        "c0ui11es",
        "c0ui1les",
        "c0uil1es",
        "c0uilles",
        "c11t",
        "c11t0",
        "c11to",
        "c1it",
        "c1it0",
        "c1ito",
        "cabr0n",
        "cabra0",
        "cabrao",
        "cabron",
        "caca",
        "cacca",
        "cacete",
        "cagante",
        "cagar",
        "cagare",
        "cagna",
        "cara1h0",
        "cara1ho",
        "caracu10",
        "caracu1o",
        "caracul0",
        "caraculo",
        "caralh0",
        "caralho",
        "cazz0",
        "cazz1mma",
        "cazzata",
        "cazzimma",
        "cazzo",
        "ch00t1a",
        "ch00t1ya",
        "ch00tia",
        "ch00tiya",
        "ch0d",
        "ch0ot1a",
        "ch0ot1ya",
        "ch0otia",
        "ch0otiya",
        "ch1asse",
        "ch1avata",
        "ch1er",
        "ch1ng0",
        "ch1ngadaz0s",
        "ch1ngadazos",
        "ch1ngader1ta",
        "ch1ngaderita",
        "ch1ngar",
        "ch1ngo",
        "ch1ngues",
        "ch1nk",
        "chatte",
        "chiasse",
        "chiavata",
        "chier",
        "ching0",
        "chingadaz0s",
        "chingadazos",
        "chingader1ta",
        "chingaderita",
        "chingar",
        "chingo",
        "chingues",
        "chink",
        "cho0t1a",
        "cho0t1ya",
        "cho0tia",
        "cho0tiya",
        "chod",
        "choot1a",
        "choot1ya",
        "chootia",
        "chootiya",
        "cl1t",
        "cl1t0",
        "cl1to",
        "clit",
        "clit0",
        "clito",
        "cock",
        "cog110ne",
        "cog11one",
        "cog1i0ne",
        "cog1ione",
        "cogl10ne",
        "cogl1one",
        "cogli0ne",
        "coglione",
        "cona",
        "connard",
        "connasse",
        "conne",
        "cou111es",
        "cou11les",
        "cou1l1es",
        "cou1lles",
        "coui11es",
        "coui1les",
        "couil1es",
        "couilles",
        "cracker",
        "crap",
        "cu10",
        "cu1att0ne",
        "cu1attone",
        "cu1er0",
        "cu1ero",
        "cu1o",
        "cul0",
        "culatt0ne",
        "culattone",
        "culer0",
        "culero",
        "culo",
        "cum",
        "cunt",
        "d11d0",
        "d11do",
        "d1ck",
        "d1ld0",
        "d1ldo",
        "damn",
        "de1ch",
        "deich",
        "depp",
        "di1d0",
        "di1do",
        "dick",
        "dild0",
        "dildo",
        "dyke",
        "encu1e",
        "encule",
        "enema",
        "enf01re",
        "enf0ire",
        "enfo1re",
        "enfoire",
        "estup1d0",
        "estup1do",
        "estupid0",
        "estupido",
        "etr0n",
        "etron",
        "f0da",
        "f0der",
        "f0ttere",
        "f0tters1",
        "f0ttersi",
        "f0tze",
        "f0utre",
        "f1ca",
        "f1cker",
        "f1ga",
        "fag",
        "fica",
        "ficker",
        "figa",
        "foda",
        "foder",
        "fottere",
        "fotters1",
        "fottersi",
        "fotze",
        "foutre",
        "fr0c10",
        "fr0c1o",
        "fr0ci0",
        "fr0cio",
        "fr0sc10",
        "fr0sc1o",
        "fr0sci0",
        "fr0scio",
        "froc10",
        "froc1o",
        "froci0",
        "frocio",
        "frosc10",
        "frosc1o",
        "frosci0",
        "froscio",
        "fuck",
        "g00",
        "g0o",
        "g0u1ne",
        "g0uine",
        "gandu",
        "go0",
        "goo",
        "gou1ne",
        "gouine",
        "gr0gnasse",
        "grognasse",
        "haram1",
        "harami",
        "haramzade",
        "hund1n",
        "hundin",
        "id10t",
        "id1ot",
        "idi0t",
        "idiot",
        "imbec11e",
        "imbec1le",
        "imbeci1e",
        "imbecile",
        "j1zz",
        "jerk",
        "jizz",
        "k1ke",
        "kam1ne",
        "kamine",
        "kike",
        "leccacu10",
        "leccacu1o",
        "leccacul0",
        "leccaculo",
        "m1erda",
        "m1gn0tta",
        "m1gnotta",
        "m1nch1a",
        "m1nchia",
        "m1st",
        "mam0n",
        "mamahuev0",
        "mamahuevo",
        "mamon",
        "masturbat10n",
        "masturbat1on",
        "masturbate",
        "masturbati0n",
        "masturbation",
        "merd0s0",
        "merd0so",
        "merda",
        "merde",
        "merdos0",
        "merdoso",
        "mierda",
        "mign0tta",
        "mignotta",
        "minch1a",
        "minchia",
        "mist",
        "musch1",
        "muschi",
        "n1gger",
        "neger",
        "negr0",
        "negre",
        "negro",
        "nerch1a",
        "nerchia",
        "nigger",
        "orgasm",
        "p00p",
        "p011a",
        "p01la",
        "p0l1a",
        "p0lla",
        "p0mp1n0",
        "p0mp1no",
        "p0mpin0",
        "p0mpino",
        "p0op",
        "p0rca",
        "p0rn",
        "p0rra",
        "p0uff1asse",
        "p0uffiasse",
        "p1p1",
        "p1pi",
        "p1r1a",
        "p1rla",
        "p1sc10",
        "p1sc1o",
        "p1sci0",
        "p1scio",
        "p1sser",
        "pa11e",
        "pa1le",
        "pal1e",
        "palle",
        "pane1e1r0",
        "pane1e1ro",
        "pane1eir0",
        "pane1eiro",
        "panele1r0",
        "panele1ro",
        "paneleir0",
        "paneleiro",
        "patakha",
        "pec0r1na",
        "pec0rina",
        "pecor1na",
        "pecorina",
        "pen1s",
        "pendej0",
        "pendejo",
        "penis",
        "pip1",
        "pipi",
        "pir1a",
        "pirla",
        "pisc10",
        "pisc1o",
        "pisci0",
        "piscio",
        "pisser",
        "po0p",
        "po11a",
        "po1la",
        "pol1a",
        "polla",
        "pomp1n0",
        "pomp1no",
        "pompin0",
        "pompino",
        "poop",
        "porca",
        "porn",
        "porra",
        "pouff1asse",
        "pouffiasse",
        "pr1ck",
        "prick",
        "pussy",
        "put1za",
        "puta",
        "puta1n",
        "putain",
        "pute",
        "putiza",
        "puttana",
        "queca",
        "r0mp1ba11e",
        "r0mp1ba1le",
        "r0mp1bal1e",
        "r0mp1balle",
        "r0mpiba11e",
        "r0mpiba1le",
        "r0mpibal1e",
        "r0mpiballe",
        "rand1",
        "randi",
        "rape",
        "recch10ne",
        "recch1one",
        "recchi0ne",
        "recchione",
        "retard",
        "romp1ba11e",
        "romp1ba1le",
        "romp1bal1e",
        "romp1balle",
        "rompiba11e",
        "rompiba1le",
        "rompibal1e",
        "rompiballe",
        "ruff1an0",
        "ruff1ano",
        "ruffian0",
        "ruffiano",
        "s1ut",
        "sa10pe",
        "sa1aud",
        "sa1ope",
        "sacanagem",
        "sal0pe",
        "salaud",
        "salope",
        "saugnapf",
        "sb0rr0ne",
        "sb0rra",
        "sb0rrone",
        "sbattere",
        "sbatters1",
        "sbattersi",
        "sborr0ne",
        "sborra",
        "sborrone",
        "sc0pare",
        "sc0pata",
        "sch1ampe",
        "sche1se",
        "sche1sse",
        "scheise",
        "scheisse",
        "schlampe",
        "schwachs1nn1g",
        "schwachs1nnig",
        "schwachsinn1g",
        "schwachsinnig",
        "schwanz",
        "scopare",
        "scopata",
        "sexy",
        "sh1t",
        "shit",
        "slut",
        "sp0mp1nare",
        "sp0mpinare",
        "spomp1nare",
        "spompinare",
        "str0nz0",
        "str0nza",
        "str0nzo",
        "stronz0",
        "stronza",
        "stronzo",
        "stup1d",
        "stupid",
        "succh1am1",
        "succh1ami",
        "succhiam1",
        "succhiami",
        "sucker",
        "t0pa",
        "tapette",
        "test1c1e",
        "test1cle",
        "testic1e",
        "testicle",
        "tette",
        "topa",
        "tr01a",
        "tr0ia",
        "tr0mbare",
        "tr1ng1er",
        "tr1ngler",
        "tring1er",
        "tringler",
        "tro1a",
        "troia",
        "trombare",
        "turd",
        "twat",
        "vaffancu10",
        "vaffancu1o",
        "vaffancul0",
        "vaffanculo",
        "vag1na",
        "vagina",
        "verdammt",
        "verga",
        "w1chsen",
        "wank",
        "wichsen",
        "x0ch0ta",
        "x0chota",
        "xana",
        "xoch0ta",
        "xochota",
        "z0cc01a",
        "z0cc0la",
        "z0cco1a",
        "z0ccola",
        "z1z1",
        "z1zi",
        "ziz1",
        "zizi",
        "zocc01a",
        "zocc0la",
        "zocco1a",
        "zoccola"
    ];

    protected MathInterface $math;

    /** @throws \InvalidArgumentException */
    public function __construct(
        protected string $alphabet = self::DEFAULT_ALPHABET,
        protected int $minLength = self::DEFAULT_MIN_LENGTH,
        protected array $blocklist = self::DEFAULT_BLOCKLIST,
    ) {
        $this->math = $this->getMathExtension();

        if ($alphabet == '') {
            $alphabet = self::DEFAULT_ALPHABET;
        }

        $alphabet = mb_convert_encoding($alphabet, 'UTF-8', mb_detect_encoding($alphabet));

        if (mb_strlen($alphabet) < 5) {
            throw new InvalidArgumentException('Alphabet length must be at least 5');
        }

        if (count(array_unique(str_split($alphabet))) !== mb_strlen($alphabet)) {
            throw new InvalidArgumentException('Alphabet must contain unique characters');
        }

        if (
            !is_int($minLength) ||
            $minLength < self::minValue() ||
            $minLength > mb_strlen($alphabet)
        ) {
            throw new InvalidArgumentException(
                'Minimum length has to be between ' . self::minValue() . ' and ' . mb_strlen($alphabet)
            );
        }

        $filteredBlocklist = [];
        $alphabetChars = str_split($alphabet);
        foreach ((array) $blocklist as $word) {
            if (mb_strlen((string) $word) >= 3) {
                $wordChars = str_split((string) $word);
                $intersection = array_filter($wordChars, fn ($c) => in_array($c, $alphabetChars));
                if (count($intersection) == count($wordChars)) {
                    $filteredBlocklist[] = strtolower((string) $word);
                }
            }
        }

        $this->alphabet = $this->shuffle($alphabet);
        $this->minLength = $minLength;
        $this->blocklist = $filteredBlocklist;
    }

    /**
     * Encodes an array of unsigned integers into an ID
     *
     * These are the cases where encoding might fail:
     * - One of the numbers passed is smaller than `minValue()` or greater than `maxValue()`
     * - A partition number is incremented so much that it becomes greater than `maxValue()`
     *
     * @param array<int> $numbers Non-negative integers to encode into an ID
     * @return string Generated ID
     */
    public function encode(array $numbers): string
    {
        if (count($numbers) == 0) {
            return '';
        }

        $inRangeNumbers = array_filter($numbers, fn ($n) => $n >= self::minValue() && $n <= self::maxValue());
        if (count($inRangeNumbers) != count($numbers)) {
            throw new \InvalidArgumentException(
                'Encoding supports numbers between ' . self::minValue() . ' and ' . self::maxValue()
            );
        }

        return $this->encodeNumbers($numbers, false);
    }

    /**
     * Internal function that encodes an array of unsigned integers into an ID
     *
     * @param array<int> $numbers Non-negative integers to encode into an ID
     * @param bool $partitioned If true, the first number is always a throwaway number (used either for blocklist or padding)
     * @return string Generated ID
     */
    protected function encodeNumbers(array $numbers, bool $partitioned = false): string
    {
        $offset = count($numbers);
        foreach ($numbers as $i => $v) {
            $offset += mb_ord($this->alphabet[$v % mb_strlen($this->alphabet)]) + $i;
        }
        $offset %= mb_strlen($this->alphabet);

        $alphabet = mb_substr($this->alphabet, $offset) . mb_substr($this->alphabet, 0, $offset);
        $prefix = $alphabet[0];
        $partition = $alphabet[1];
        $alphabet = mb_substr($alphabet, 2);
        $ret = [$prefix];

        for ($i = 0; $i != count($numbers); $i++) {
            $num = $numbers[$i];

            $alphabetWithoutSeparator = mb_substr($alphabet, 0, -1);
            $ret[] = $this->toId($num, $alphabetWithoutSeparator);

            if ($i < count($numbers) - 1) {
                $separator = $alphabet[-1];

                if ($partitioned && $i == 0) {
                    $ret[] = $partition;
                } else {
                    $ret[] = $separator;
                }

                $alphabet = $this->shuffle($alphabet);
            }
        }

        $id = implode('', $ret);

        if ($this->minLength > mb_strlen($id)) {
            if (!$partitioned) {
                array_unshift($numbers, 0);
                $id = $this->encodeNumbers($numbers, true);
            }

            if ($this->minLength > mb_strlen($id)) {
                $id = $id[0] . mb_substr($alphabet, 0, $this->minLength - mb_strlen($id)) . mb_substr($id, 1);
            }
        }

        if ($this->isBlockedId($id)) {
            if ($partitioned) {
                if ($numbers[0] + 1 > self::maxValue()) {
                    throw new \RuntimeException('Ran out of range checking against the blocklist');
                } else {
                    $numbers[0] += 1;
                }
            } else {
                array_unshift($numbers, 0);
            }

            $id = $this->encodeNumbers($numbers, true);
        }

        return $id;
    }

    /**
     * Decodes an ID back into an array of unsigned integers
     *
     * These are the cases where the return value might be an empty array:
     * - Empty ID / empty string
     * - Invalid ID passed (reserved character is in the wrong place)
     * - Non-alphabet character is found within the ID
     *
     * @param string $id Encoded ID
     * @return array<int> Array of unsigned integers
     */
    public function decode(string $id): array
    {
        $ret = [];

        if ($id == '') {
            return $ret;
        }

        $alphabetChars = str_split($this->alphabet);
        foreach (str_split($id) as $c) {
            if (!in_array($c, $alphabetChars)) {
                return $ret;
            }
        }

        $prefix = $id[0];
        $offset = strpos($this->alphabet, $prefix);
        $alphabet = mb_substr($this->alphabet, $offset) . mb_substr($this->alphabet, 0, $offset);
        $partition = $alphabet[1];
        $alphabet = mb_substr($alphabet, 2);
        $id = mb_substr($id, 1);

        $partitionIndex = strpos($id, $partition);
        if ($partitionIndex > 0 && $partitionIndex < mb_strlen($id) - 1) {
            $id = mb_substr($id, $partitionIndex + 1);
            $alphabet = $this->shuffle($alphabet);
        }

        while (mb_strlen($id) > 0) {
            $separator = $alphabet[-1];

            $chunks = explode($separator, $id, 2);
            if (!empty($chunks)) {
                $alphabetWithoutSeparator = mb_substr($alphabet, 0, -1);
                $ret[] = $this->toNumber($chunks[0], $alphabetWithoutSeparator);

                if (count($chunks) > 1) {
                    $alphabet = $this->shuffle($alphabet);
                }
            }

            $id = $chunks[1] ?? '';
        }

        return $ret;
    }

    public static function minValue(): int
    {
        return 0;
    }

    public static function maxValue(): int
    {
        return PHP_INT_MAX;
    }

    protected function shuffle(string $alphabet): string
    {
        $chars = str_split($alphabet);

        for ($i = 0, $j = count($chars) - 1; $j > 0; $i++, $j--) {
            $r = ($i * $j + mb_ord($chars[$i]) + mb_ord($chars[$j])) % count($chars);
            [$chars[$i], $chars[$r]] = [$chars[$r], $chars[$i]];
        }

        return implode('', $chars);
    }

    protected function toId(int $num, string $alphabet): string
    {
        $id = [];
        $chars = str_split($alphabet);

        $result = $num;

        do {
            array_unshift($id, $chars[$this->math->intval($this->math->mod($result, count($chars)))]);
            $result = $this->math->divide($result, count($chars));
        } while ($this->math->greaterThan($result, 0));

        return implode('', $id);
    }

    protected function toNumber(string $id, string $alphabet): int
    {
        $chars = str_split($alphabet);
        return $this->math->intval(array_reduce(str_split($id), function ($a, $v) use ($chars) {
            $number = $this->math->multiply($a, count($chars));
            $number = $this->math->add($number, array_search($v, $chars));

            return $number;
        }, 0));
    }

    protected function isBlockedId(string $id): bool
    {
        $id = strtolower($id);

        foreach ($this->blocklist as $word) {
            if (mb_strlen((string) $word) <= mb_strlen($id)) {
                if (mb_strlen($id) <= 3 || mb_strlen((string) $word) <= 3) {
                    if ($id == $word) {
                        return true;
                    }
                } elseif (preg_match('/~[0-9]+~/', (string) $word)) {
                    if (str_starts_with($id, (string) $word) || strrpos($id, (string) $word) === mb_strlen($id) - mb_strlen((string) $word)) {
                        return true;
                    }
                } elseif (str_contains($id, (string) $word)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get BC Math or GMP extension.
     * @throws \RuntimeException
     */
    protected function getMathExtension(): MathInterface
    {
        if (extension_loaded('gmp')) {
            return new Gmp();
        }

        if (extension_loaded('bcmath')) {
            return new BCMath();
        }

        throw new RuntimeException('Missing math extension for Sqids, install either bcmath or gmp.');
    }
}
