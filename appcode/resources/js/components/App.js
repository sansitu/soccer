import React, { Component } from 'react';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faUsers, faBuilding, faHome, faSearch } from '@fortawesome/free-solid-svg-icons';
import Dashboard from './Dashboard/Dashboard';
import Team from './Team/Team';
import Player from './Player/Player';
import Home from './Home/Home';
import Detail from './Detail/Detail';
import './App.css';

library.add(faUsers, faBuilding, faHome, faSearch)

class App extends Component {
    render() {
    	let content;

        if (window.location.pathname == "/dashboard") {
            content = <Dashboard/>;
        } else if (window.location.pathname == "/team") {
            content = <Team/>;
        } else if (window.location.pathname == "/player") {
            content = <Player/>
        } else if (window.location.pathname == "/detail") {
            content = <Detail/>
        } else if (window.location.pathname == "/") {
            content = <Home/>;
        }

        return (
            <div className="row justify-content-center">
                <div className="col-md-12">
                    { content }
                </div>
            </div>
        );
    }
}

export default App;