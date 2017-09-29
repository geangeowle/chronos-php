
/**
 * [greeter description]
 * @param  {string} person [description]
 * @return {[type]}        [description]
 */
function greeter(person: string) {
    return "Hello, " + person;
}

var user = "Jane User ->";
document.body.innerHTML = greeter(user);
console.log(user);
