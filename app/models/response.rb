class Response < ActiveRecord::Base
  attr_accessible :content, :email, :name, :package_id
end
