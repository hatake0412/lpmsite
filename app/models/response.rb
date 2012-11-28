class Response < ActiveRecord::Base
  attr_accessible :content, :email, :name, :package_id
  validates :content, :email,:presence => true
belongs_to :package
end
