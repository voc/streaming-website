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
			sh('./deploy-staging.sh')
			// currentBuild.displayName = "${IMAGE_TAG}_${BUILD_NUMBER}"
		}
	}
}