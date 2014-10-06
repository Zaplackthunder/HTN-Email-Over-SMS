Rails.application.config.middleware.use OmniAuth::Builder do
  provider :google_oauth2, ENV["GOOGLE_CLIENT_ID"], ENV["GOOGLE_CLIENT_SECRET"], {
  	:scope => 'email,https://www.googleapis.com/auth/gmail.readonly,https://www.googleapis.com/auth/gmail.compose',
  	:client_options => {:ssl => {:verify => false}}
  }
end