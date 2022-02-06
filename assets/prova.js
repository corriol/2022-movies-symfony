let React = require('react');

class ShoppingList extends React.Component {
    render() {
        return (
            <div className="shopping-list">
                <h1>Shopping List for {this.props.name}</h1>
                <ul>
                    <li>Instagram</li>
                    <li>WhatsApp</li>
                    <li>Oculus</li>
                </ul>
            </div>
        );
    }
}

let ReactDOM = require('react-dom');

const element = React.createElement(
    'h1',
    {className: 'greeting'},
    'Hello, world!'
);

ReactDOM.render(element, document.getElementById('root'));

ReactDOM.render(
    <h1>Hello, world!</h1>,
    document.getElementById('root')
);

class Welcome extends React.Component {
    render() {
        return <h1>Hello, {this.props.name}</h1>;
    }
}

const shopping = <ShoppingList name="Mark" />;

/* ReactDOM.render(
    shopping,
    document.getElementById('root')
); */


const movie = React.createElement(
    'h3',
    {className: 'greeting'},
    'Hello, world!'
);

class StarRating extends React.Component {

    render() {
        //let movies = this.select();
        //for (let i=0; i< movies.length; i=i+1) {
         //   let moviesDiv = movies[i];
        return movie;

    }
}

document.addEventListener('DOMContentLoaded',
    function (e) {
        let movies = document.querySelectorAll('.movie');
        for (let i=0; i< movies.length; i=i+1) {
            let movie = movies[i];
            ReactDOM.render(
                <StarRating />,
                movie.appendChild(document.createElement('div')));
        }
    }
)
