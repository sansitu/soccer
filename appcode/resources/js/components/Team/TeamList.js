import React, { Component } from 'react';
import { NO_IMAGE_PATH } from '../config';

class TeamList extends Component {

	constructor(props) {
        super(props);
    }

    render() {
        return (
			<div className="row justify-content-center">
			    <div className="col-md-12">
			        <div className="card">
			            <div className="card-header cardHeader">Teams</div>
			            <div className="card-body">
            		  	  	{this.props.data.map(team =>
            		  	  		<a href={'team-details/' + team.id} key={'team-details/' + team.id}>
	           						<div key={team.id} className="divList">
										<div className="divImage"><img src={team.logo_url === null ? `${NO_IMAGE_PATH}` : team.logo_url} className="imgSize"/></div>
										<div className="divLabel">{team.name}</div>
									</div>
								</a>
    						)}
                   		</div>
			        </div>
			    </div>
			</div>
		);
	}
}

export default TeamList;