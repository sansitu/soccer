import React, { Component } from 'react';
import axios from 'axios';
import Spinner from '../Spinner/Spinner';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import './Dashboard.css';

class Dashboard extends Component {
	constructor() {
        super();
        
        this.state = {
            home: [],
            loading: false
        }
    }

    componentWillMount() {
        this.setState({ loading: true })

        axios.get('/dashboard/content').then(response =>  {
            this.setState({
                home: response.data,
                loading: false
            });
            console.log(response.data);
        }).catch(errors => {
            console.log(errors);
        })
    }

    render() {
        return (
            <div className="row">
                <span className="spanSpinner">{ this.state.loading ? <Spinner /> : null }</span>

                <div className="col-xs-12 col-md-6 col-lg-6" id="team">
                    <div className="panel panel-blue panel-widget">
                        <div className="row no-padding">
                            <div className="col-sm-3 col-lg-5 widget-left">
                                <FontAwesomeIcon icon="building" className="teamIcon" size="3x"/>
                            </div>
                            <div className="col-sm-9 col-lg-7 widget-right">
                                <div className="large" id="statUser">{ this.state.home.total_team === null ? '0' : this.state.home.total_team }</div>
                                <div className="text-muted">Team</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-xs-12 col-md-6 col-lg-6" id="player">
                    <div className="panel panel-orange panel-widget">
                        <div className="row no-padding">
                            <div className="col-sm-3 col-lg-5 widget-left">
                                <FontAwesomeIcon icon="users" className="playerIcon" size="3x"/>
                            </div>
                            <div className="col-sm-9 col-lg-7 widget-right">
                                <div className="large" id="statCompany">{ this.state.home.total_player === null ? '0' : this.state.home.total_player }</div>
                                <div className="text-muted">Player</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Dashboard;