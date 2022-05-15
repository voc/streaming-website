#!groovy

final def BRANCH = env.BRANCH_NAME

node {
	properties([
			disableConcurrentBuilds()
	])

	stage('git') {
		checkout([
				$class             : 'GitSCM',
				branches           : scm.branches,
				userRemoteConfigs  : scm.userRemoteConfigs
		])
	}

	stage('deploy') {
		if (BRANCH == 'staging') {
			sh('./deploy-staging.sh --without-validation')
			// currentBuild.displayName = "${IMAGE_TAG}_${BUILD_NUMBER}"
		} else if (BRANCH == 'master') {
			input('Are you sure?')
			sh('./deploy.sh --without-validation')
			// currentBuild.displayName = "${IMAGE_TAG}_${BUILD_NUMBER}"
		}
	}
}