class Package < ActiveRecord::Base
  attr_accessible :cnt, :depends, :description, :name, :note, :ver
  validates :name, :ver, :description,:presence => true
end
