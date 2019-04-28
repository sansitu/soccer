import React, { Component } from 'react';
import axios from 'axios';
import Spinner from '../Spinner/Spinner';
import TeamList from '../Team/TeamList';
import PlayerList from '../Player/PlayerList';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

class Home extends Component {
	
	constructor() {
        super();
        
        this.state = {
            teams: [],
            players: [],
            loading: false
        }
    }

    componentWillMount() {
        this.setState({ loading: true })

        this.setState({ loading: true })
    	
    	this.bindPlayer();  

        this.bindTeam();
    }

    bindPlayer() {
    	axios.get('/api/v1/player').then(response =>  {
            this.setState({
                players: response.data.player,
                loading: false
            });
        }).catch(errors => {
            console.log(errors);
        })
    }

    bindTeam() {
        axios.get('/api/v1/team').then(response =>  {
            this.setState({
                teams: response.data.team,
                loading: false
            });
        }).catch(errors => {
            console.log(errors);
        })
    }


    render() {
        return (
            <div className="row">
                <div className="container">

	            	<TeamList data={this.state.teams}/>
	                <PlayerList data={this.state.players}/>
	            </div>
            </div>
        );
    }
}

export default Home;