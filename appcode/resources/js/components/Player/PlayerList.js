import React, { Component } from 'react';
import { NO_IMAGE_PATH } from '../config';

class PlayerList extends Component {

	constructor(props) {
        super(props);
    }

    render() {
        return (
			<div className="row justify-content-center">
			    <div className="col-md-12">
			        <div className="card">
			            <div className="card-header cardHeader">Players</div>
			            <div className="card-body">
            		  	  	{this.props.data.map(player => 
           						<div key={player.id} className="divList">
									<div className="divImage"><img src={player.photo_url === null ? `${NO_IMAGE_PATH}` : player.photo_url} className="imgSize"/></div>
									<div className="divLabel">{player.first_name} {player.last_name}</div>
								</div>
    						)}
                   		</div>
			        </div>
			    </div>
			</div>
		);
	}
}

export default PlayerList;