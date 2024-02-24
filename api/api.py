from flask import Flask, request, jsonify
import docker
import socket

app = Flask(__name__)

docker_client = docker.from_env()


@app.route('/create_container', methods=['GET'])
def create_container():
    response = {}

    try:
        username = request.args.get('username')
        password = request.args.get('password')
        containername = request.args.get('containername')

        

        
     
        network_name = "procon"
        try:
            docker_client.networks.get(network_name)
        except docker.errors.NotFound:
            docker_client.networks.create(network_name)

        container = docker_client.containers.run(
                image='vikesh001/ubuntu-ssh',
                detach=True,
                
                environment={
                    'ROOT_PASSWORD': password,
                    'USERNAME': username
                },
                name=containername,
                network=network_name
            )

        response = {
                        "message": "Container created successfully!",
                        "username": username,
                        "rootpass": password,
                        "containername": containername,
                        "containerid": container.id,
                        
                    }
    except Exception as e:
        response = {"error": str(e)}

    return jsonify(response)

@app.route('/stop_container', methods=['GET'])
def stop_container():
    response = {}
    containername = request.args.get('containername')

    try:
        container = docker_client.containers.get(containername)
        container.stop()
        response = {"message": f"Container '{containername}' has been stopped."}
    except docker.errors.NotFound:
        response = {"error": f"Container '{containername}' not found."}

    return jsonify(response)

@app.route('/start_container', methods=['GET'])
def start_container():
    response = {}
    containername = request.args.get('containername')

    try:
        container = docker_client.containers.get(containername)
        container.start()
        response = {"message": f"Container '{containername}' has been started."}
    except docker.errors.NotFound:
        response = {"error": f"Container '{containername}' not found."}

    return jsonify(response)

@app.route('/restart_container', methods=['GET'])
def restart_container():
    response = {}
    containername = request.args.get('containername')

    try:
        container = docker_client.containers.get(containername)
        container.restart()
        response = {"message": f"Container '{containername}' has been restarted."}
    except docker.errors.NotFound:
        response = {"error": f"Container '{containername}' not found."}

    return jsonify(response)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
