/** Generates UUID v4
 *
 * @node There is a bug in Chrome's Math.random() according to http://devoluk.com/google-chrome-math-random-issue.html
 *       For that reason we use Date.now() as well.
 *
 * Taken from https://gist.github.com/duzun/d1bfb5406a362e06eccd
 */
function UUID() {
    function s(n) { return h((Math.random() * (1<<(n<<2)))^Date.now()).slice(-n); }
    function h(n) { return (n|0).toString(16); }
    return  [
        s(4) + s(4), s(4),
        '4' + s(3),                    // UUID version 4
        h(8|(Math.random()*4)) + s(3), // {8|9|A|B}xxx
        // s(4) + s(4) + s(4),
        Date.now().toString(16).slice(-10) + s(2) // Use timestamp to avoid collisions
    ].join('-');
}
